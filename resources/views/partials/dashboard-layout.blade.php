
<script>
    (function () {
        'use strict';

        const CONFIG = {
            lectures: {
                grid: '#lecturesGrid',
                section: '.lectures-section',
                card: '[data-lecture-card]',
                minW: 128,
                minH: 60,
                refW: 208,
                target: 2.2,
                kMin: 0.34,
                kMax: 1.12,
                factor: '--k',
                tiers: [
                    { name: 'ultra', maxCh: 90, refH: 92 },
                    { name: 'tight', maxCh: 130, refH: 132 },
                    { name: 'normal', maxCh: Infinity, refH: 163 }
                ]
            },
            rooms: {
                grid: '#roomsGrid',
                section: '.rooms-section',
                card: '.room-card',
                minW: 100,
                minH: 32,
                refW: 150,
                target: 2.5,
                kMin: 0.42,
                kMax: 1.2,
                factor: '--rk',
                tiers: [
                    { name: 'ultra', maxCh: 40, refH: 50 },
                    { name: 'normal', maxCh: Infinity, refH: 70 }
                ]
            }
        };

        function clamp(value, min, max) {
            return Math.min(Math.max(value, min), max);
        }

        function gapOf(element) {
            const gap = parseFloat(getComputedStyle(element).rowGap);
            return isFinite(gap) ? gap : 8;
        }

        /* Pick the (cols, rows) that fits every card; when the
           screen is too small, keep the smallest shortfall. */
        function plan(count, width, height, gap, config) {
            if (count < 1 || width < 1 || height < 1) {
                return {
                    cols: 1,
                    rows: 1,
                    cw: width,
                    ch: height
                };
            }

            let best = null;
            let bestScore = -Infinity;

            for (let cols = 1; cols <= count; cols += 1) {
                const rows = Math.ceil(count / cols);
                const cw = (width - gap * (cols - 1)) / cols;
                const ch = (height - gap * (rows - 1)) / rows;

                if (cw <= 0 || ch <= 0) {
                    continue;
                }

                const fits = cw >= config.minW && ch >= config.minH;
                const aspect = -Math.abs(Math.log((cw / ch) / config.target));

                const score = fits
                    ? 100 + aspect + Math.min(ch / config.minH, 2.4) * 0.8 + Math.min(cw / config.minW, 2.4) * 0.2
                    : Math.min(cw / config.minW, ch / config.minH) * 10;

                if (score > bestScore) {
                    bestScore = score;
                    best = {
                        cols: cols,
                        rows: rows,
                        cw: cw,
                        ch: ch
                    };
                }
            }

            return best || {
                cols: Math.min(count, 4),
                rows: Math.ceil(count / Math.min(count, 4)),
                cw: width,
                ch: height
            };
        }

        function tierOf(config, cardHeight) {
            for (let i = 0; i < config.tiers.length; i += 1) {
                if (cardHeight < config.tiers[i].maxCh) {
                    return config.tiers[i];
                }
            }

            return config.tiers[config.tiers.length - 1];
        }

        function applyPlan(grid, config, result) {
            const tier = tierOf(config, result.ch);

            grid.style.setProperty('--cols', result.cols);
            grid.style.setProperty('--rows', result.rows);
            grid.style.setProperty('--cw', Math.max(result.cw, 0).toFixed(2) + 'px');
            grid.style.setProperty('--ch', Math.max(result.ch, 0).toFixed(2) + 'px');
            grid.style.setProperty(
                config.factor,
                clamp(
                    Math.min(result.ch / tier.refH, result.cw / config.refW),
                    config.kMin,
                    config.kMax
                ).toFixed(3)
            );
            grid.dataset.density = tier.name;
        }

        function resolve(name) {
            const config = CONFIG[name];
            const grid = document.querySelector(config.grid);
            const section = document.querySelector(config.section);

            if (!grid || !section) {
                return null;
            }

            const header = section.querySelector('.section-header');
            let cost = 0;

            if (header) {
                cost = header.offsetHeight + (parseFloat(getComputedStyle(header).marginBottom) || 0);
            }

            return {
                config: config,
                grid: grid,
                section: section,
                cost: cost,
                gap: gapOf(grid),
                count: grid.querySelectorAll(config.card).length
            };
        }

        function fitDashboard() {
            const content = document.querySelector('.dashboard-content');
            const lectures = resolve('lectures');
            const rooms = resolve('rooms');

            if (!content || !lectures || !rooms) {
                return;
            }

            const total = content.clientHeight;
            const width = content.clientWidth;

            if (total < 1 || width < 1) {
                return;
            }

            let share = 0.62;

            /* Converge on the vertical split each section deserves. */
            for (let i = 0; i < 4; i += 1) {
                const freeL = Math.max(1, total * share - lectures.cost);
                const freeR = Math.max(1, total * (1 - share) - rooms.cost);

                const planL = plan(lectures.count, width, freeL, lectures.gap, lectures.config);
                const planR = plan(rooms.count, width, freeR, rooms.gap, rooms.config);

                const needL = lectures.cost + planL.rows * (lectures.count ? lectures.config.minH : 46) + (planL.rows - 1) * lectures.gap;
                const needR = rooms.cost + planR.rows * (rooms.count ? rooms.config.minH : 46) + (planR.rows - 1) * rooms.gap;

                share = clamp(needL / (needL + needR), 0.34, 0.86);
            }

            lectures.section.style.flex = share.toFixed(4) + ' 1 0px';
            rooms.section.style.flex = (1 - share).toFixed(4) + ' 1 0px';

            /* Re-measure with the split applied, then commit the plans. */
            applyPlan(
                lectures.grid,
                lectures.config,
                plan(
                    lectures.count,
                    lectures.grid.clientWidth,
                    lectures.grid.clientHeight,
                    lectures.gap,
                    lectures.config
                )
            );

            applyPlan(
                rooms.grid,
                rooms.config,
                plan(
                    rooms.count,
                    rooms.grid.clientWidth,
                    rooms.grid.clientHeight,
                    rooms.gap,
                    rooms.config
                )
            );
        }

        let frame = null;

        function requestFit() {
            if (frame) {
                cancelAnimationFrame(frame);
            }

            frame = requestAnimationFrame(function () {
                frame = null;
                fitDashboard();
            });
        }

        window.fitDashboard = fitDashboard;
        window.requestDashboardFit = requestFit;

        window.addEventListener('resize', requestFit);
        window.addEventListener('orientationchange', requestFit);

        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(requestFit);
        }

        requestFit();
    })();
</script>

