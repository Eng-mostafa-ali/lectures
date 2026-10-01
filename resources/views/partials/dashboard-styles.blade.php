<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,700&display=swap');

    :root {
        /* Modern Light Theme Palette with High-Contrast Background */
        --bg-deep: #e8ecf2;
        --page-bg: #e8ecf2;

        /* Logo Inspired Accents - Refined for Light Mode */
        --brand-teal: #0d9488;
        --brand-teal-light: #14b8a6;
        --brand-teal-glow: rgba(13, 148, 136, 0.15);
        --brand-teal-soft: #ecfdf5;
        --brand-teal-border: #a7f3d0;

        --brand-lime: #65a30d;
        --brand-lime-light: #84cc16;
        --brand-lime-glow: rgba(101, 163, 13, 0.15);
        --brand-lime-soft: #f7fee7;
        --brand-lime-border: #d9f99d;

        --brand-cyan: #0284c7;

        /* Surfaces & Cards (Crisp Clean White) */
        --surface: #ffffff;
        --surface-solid: #ffffff;
        --surface-card: #ffffff;
        --surface-hover: #f8fafc;
        --surface-inner: #f1f5f9;

        /* Typography */
        --ink: #0f172a;
        --ink-soft: #334155;
        --muted: #64748b;
        --muted-dark: #94a3b8;

        /* Borders & Lines */
        --line: #cbd5e1;
        --line-soft: #e2e8f0;
        --line-highlight: rgba(13, 148, 136, 0.3);

        /* Status Colors - Light & Vivid */
        /* 1. Not Started: Distinct Sleek Slate Dark Tint for visual hierarchy */
        --status-not-started-bg: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
        --status-not-started-border: #334155;
        --status-not-started-accent: #94a3b8;

        /* 2. Waiting (Overdue start / Delayed): Vibrant Coral-Red Alert */
        --status-waiting-bg: linear-gradient(180deg, #fff1f2 0%, #ffffff 60%);
        --status-waiting-border: #f43f5e;
        --status-waiting-accent: #e11d48;

        /* 3. In Progress (Active): Crisp Mint/Teal Tint with Gradient Accent */
        --status-progress-bg: #f0fdfa;
        --status-progress-border: #0d9488;
        --status-progress-glow: 0 4px 16px rgba(13, 148, 136, 0.12);

        /* 4. Finished: Soft Light Gray */
        --status-finished-bg: #f1f5f9;
        --status-finished-border: #cbd5e1;
        --status-finished-accent: #94a3b8;

        /* 5. Cancelled: Crimson / Deep Red Alert */
        --status-cancelled-bg: linear-gradient(180deg, #fef2f2 0%, #ffffff 60%);
        --status-cancelled-border: #ef4444;
        --status-cancelled-accent: #dc2626;

        /* Shadows & Radii */
        --shadow-card: 0 3px 12px rgba(15, 23, 42, 0.07), 0 1px 3px rgba(15, 23, 42, 0.04);
        --shadow-card-hover: 0 12px 28px -4px rgba(13, 148, 136, 0.16), 0 4px 12px rgba(15, 23, 42, 0.08);
        --radius-card: 12px;
        --radius-control: 8px;
        --top-bar: 4px;

        /* Legacy compat vars */
        --blue: #0d9488;
        --teal: #0d9488;
        --teal-ink: #0f766e;
        --teal-soft: #f0fdfa;
        --danger: #ef4444;
        --danger-soft: #fef2f2;
    }

    /* ==========================================================
       BASE
    ========================================================== */
    * {
        box-sizing: border-box;
    }

    html,
    body {
        height: 100%;
        max-height: 100%;
        margin: 0;
        padding: 0;
        overflow: hidden;
    }

    body {
        background: #e8ecf2;
        color: var(--ink);
        border-top: var(--top-bar) solid;
        border-image: linear-gradient(90deg, #14b8a6, #84cc16) 1;
        font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        -webkit-font-smoothing: antialiased;
    }

    /* ==========================================================
       PAGE / LAYOUT
    ========================================================== */
    .dashboard-wrapper {
        width: 100%;
        height: calc(100dvh - var(--top-bar));
        max-height: calc(100dvh - var(--top-bar));
        padding: clamp(8px, 1.3vh, 16px) clamp(8px, 1.2vw, 20px);
        display: flex;
        flex-direction: column;
        gap: clamp(6px, 1vh, 12px);
        overflow: hidden;
        background: radial-gradient(circle at 16% 2%, rgba(24, 168, 117, .12), transparent 25rem), radial-gradient(circle at 88% 0%, rgba(30, 99, 199, .14), transparent 31rem), linear-gradient(180deg, #fbfdff, #f6faff 46%, #fff);
    }

    .dashboard-header {
        flex: 0 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: clamp(6px, 0.9vh, 10px) clamp(10px, 1.2vw, 16px);
        background: #ffffff;
        border: 1px solid var(--line);
        border-radius: var(--radius-card);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .dashboard-title {
        margin: 0;
        color: #0f172a;
        font-size: clamp(16px, 2.2vh, 24px);
        font-weight: 800;
        line-height: 1.15;
        letter-spacing: -0.02em;
        display: flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, #0f172a 30%, #0d9488 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .dashboard-date {
        margin-top: 2px;
        color: var(--muted);
        font-size: clamp(9px, 1.05vh, 11px);
        font-weight: 600;
        letter-spacing: .02em;
    }

    .dashboard-summary {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        flex-wrap: wrap;
        gap: 8px;
    }

    .total-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        min-height: 0;
        padding: clamp(5px, 0.8vh, 8px) clamp(9px, 0.9vw, 14px);
        background: #ffffff;
        border: 1px solid var(--line);
        border-radius: var(--radius-control);
        color: var(--ink-soft);
        font-size: clamp(9px, 1.05vh, 11px);
        font-weight: 700;
        white-space: nowrap;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        transition: border-color .2s ease, transform .2s ease, box-shadow .2s ease;
    }

    .total-badge:hover {
        border-color: var(--brand-teal-light);
        box-shadow: 0 3px 8px rgba(13, 148, 136, 0.08);
        transform: translateY(-1px);
    }

    .total-badge i {
        color: var(--brand-teal);
        font-size: 1.1em;
    }

    .total-badge:nth-child(2) i {
        color: var(--brand-lime);
    }

    .summary-value {
        color: var(--brand-teal-light);
        font-size: clamp(10px, 1.25vh, 13px);
        font-weight: 800;
        font-variant-numeric: tabular-nums;
        background: var(--brand-teal-soft);
        padding: 2px 7px;
        border-radius: 6px;
        border: 1px solid var(--brand-teal-border);
    }

    .total-badge:nth-child(2) .summary-value {
        background: var(--brand-lime-soft);
        border-color: var(--brand-lime-border);
        color: var(--brand-lime);
    }

    .dashboard-content {
        flex: 1 1 auto;
        min-height: 0;
        display: flex;
        flex-direction: column;
        gap: clamp(6px, 1vh, 14px);
        overflow: hidden;
    }

    .dashboard-section,
    .lectures-section {
        flex: 1 1 0;
        min-height: 0;
        display: flex;
        flex-direction: column-reverse;
        min-width: 0;
        overflow: hidden;

    }

    .section-header {
        flex: 0 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin: 0 0 clamp(4px, .7vh, 8px);
        padding: 0 2px;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #0f172a;
        font-size: clamp(11px, 1.45vh, 15px);
        font-weight: 800;
        letter-spacing: -0.01em;
        text-transform: uppercase;
    }

    .section-title i {
        font-size: clamp(12px, 1.6vh, 16px);
        color: var(--brand-teal) !important;
    }

    .rooms-section .section-title i {
        color: var(--brand-lime) !important;
    }

    .section-count {
        padding: clamp(3px, .55vh, 6px) clamp(8px, .75vw, 13px);
        background: #ffffff;
        border: 1px solid var(--line);
        border-radius: 999px;
        color: var(--muted);
        font-size: clamp(8px, .95vh, 10.5px);
        font-weight: 700;
        letter-spacing: 0.03em;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
    }

    /* ==========================================================
       GRIDS
    ========================================================= */
    .lectures-grid,
    .rooms-grid {
        --gap: clamp(5px, .6vw, 12px);
        flex: 1 1 auto;
        min-height: 0;
        display: grid;
        gap: var(--gap);
        grid-template-columns: repeat(var(--cols, 4), minmax(0, 1fr));
        grid-template-rows: repeat(var(--rows, 1), minmax(0, 1fr));
        width: 100%;
        overflow: hidden;
    }

    .empty-card {
        min-height: 0;
        display: grid;
        place-items: center;
        padding: clamp(8px, 1.4vh, 24px);
        background: #ffffff;
        border: 1px dashed var(--line);
        border-radius: var(--radius-card);
        color: var(--muted);
        font-size: clamp(9px, 1.2vh, 12px);
        font-weight: 600;
        text-align: center;
    }

    /* ==========================================================
       LECTURE CARD
    ========================================================== */
    .lecture-card {
        position: relative;


        padding: calc(9px * var(--k, 1));
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: calc(4px * var(--k, 1));
        overflow: hidden;
        background: #ffffff;
        border: 0.5px solid var(--line);
        border-radius: clamp(6px, calc(11px * var(--k, 1)), 12px);
        box-shadow: var(--shadow-card);
        color: var(--ink);
        line-height: 1.15;
        cursor: pointer;
        height: auto !important;
        min-height: max-content;
        width: 100%;


        margin: 0 !important;
        
        transition: transform .22s cubic-bezier(0.16, 1, 0.3, 1),
            box-shadow .22s ease,
            border-color .22s ease,
            background .22s ease;
    }

    .lectures-container {

        display: grid;
        gap: 16px;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));

        justify-content: start;
        align-items: start;
    }

    .parent-container {
        display: grid !important;
        gap: 16px !important;
        align-items: start !important;
        justify-content: start !important;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)) !important;
    }

    .lecture-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: calc(3.5px * var(--k, 1));
        background: transparent;
        z-index: 2;
        transition: background .2s ease;
    }

    .lecture-card:hover {
        transform: translateY(-3px) scale(1.008);
        box-shadow: var(--shadow-card-hover);
        z-index: 5;
    }

    .lecture-card:focus-visible {
        outline: 2px solid var(--brand-teal);
        outline-offset: 2px;
    }

    /* --- states ------------------------------------------ */
    /* 1. NOT STARTED (White card with prominent dark slate border & accents) */
    .lecture-not-started {
        background: linear-gradient(180deg, #d5e2f0 0%, #ffffff 60%);
        /* border: 0.5px solid #334155; */
        color: #123f86;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.06), 0 1px 2px rgba(15, 23, 42, 0.04);
    }

    .lecture-not-started::before {
        /* background: #123f86; */
        /* height: calc(3px * var(--k, 1)); */
    }

    .lecture-not-started:hover {
        /* border-color: #123f86; */
        /* box-shadow: 0 8px 20px rgba(15, 23, 42, 0.12); */
    }

    /* 2. IN PROGRESS */
    .lecture-in-progress {
        background: linear-gradient(180deg, #bcf5e7 0%, #ffffff 60%);
        /* border-color: var(--brand-teal-light); */
        box-shadow: 0 4px 14px rgba(13, 148, 136, 0.12), 0 1px 3px rgba(0, 0, 0, 0.04);
    }

    .lecture-in-progress::before {
        /* background: linear-gradient(90deg, #14b8a6, #84cc16); */
    }

    .lecture-in-progress:hover {
        border-color: var(--brand-teal);
        box-shadow: 0 8px 24px rgba(13, 148, 136, 0.18);
    }

    /* 3. WAITING (Action Needed - Vibrant Red/Coral) */
    .lecture-waiting {
        background: linear-gradient(180deg, #e05f68 0%, #ffffff 60%);
        /* border-color: var(--status-waiting-border); */
        box-shadow: 0 4px 14px rgba(244, 63, 94, 0.15);
    }

    .lecture-waiting::before {
        /* background: linear-gradient(90deg, #f43f5e, #fb7185); */
    }

    .lecture-waiting:hover {
        border-color: #e11d48;
        box-shadow: 0 8px 22px rgba(244, 63, 94, 0.22);
    }

    /* 4. CANCELLED (Deep Crimson Red) */
    .lecture-cancelled {
        background: linear-gradient(180deg, #e05f68 0%, #ffffff 60%);
        /* border-color: var(--status-cancelled-border); */
        box-shadow: 0 4px 14px rgba(233, 50, 50, 0.12);
        opacity: 0.92;
    }

    .lecture-cancelled::before {
        /* background: linear-gradient(90deg, #dc2626, #ef4444); */
    }

    .lecture-cancelled:hover {
        /* border-color: #b91c1c; */
        /* box-shadow: 0 8px 22px rgba(239, 68, 68, 0.2); */
    }

    /* 5. FINISHED */
    .lecture-finished {
        background: #f8fafc;
        border-color: var(--line);
        opacity: 0.8;
    }

    .lecture-finished:hover {
        opacity: 1;
    }

    /* --- header ------------------------------------------ */
    .lecture-top {
        flex: 0 0 auto;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: calc(6px * var(--k, 1));
    }

    .lecture-main {
        flex: 1;
        min-width: 0;
        display: flex;
        align-items: center;
    }

    .lecture-icon {
        width: calc(34px * var(--k, 1));
        height: calc(34px * var(--k, 1));
        min-width: calc(18px * var(--k, 1));
        margin-right: calc(8px * var(--k, 1));
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: calc(8px * var(--k, 1));
        background: #f0fdfa;
        border: 1px solid var(--brand-teal-border);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    }

    .lecture-icon i {
        color: var(--brand-teal);
        font-size: calc(18px * var(--k, 1));
    }

    .lecture-not-started .lecture-icon {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }

    .lecture-not-started .lecture-icon i {
        color: #123f86;
    }

    .lecture-waiting .lecture-icon {
        background: #ffe4e6;
        border-color: #fecdd3;
    }

    .lecture-waiting .lecture-icon i {
        color: #e11d48;
    }

    .lecture-cancelled .lecture-icon {
        background: #fee2e2;
        border-color: #fecaca;
    }

    .lecture-cancelled .lecture-icon i {
        color: #dc2626;
    }

    .lecture-info {
        flex: 1;
        min-width: 0;
    }

    .lecture-room {
        min-width: 0;
        overflow: hidden;
        color: #0f172a;
        font-size: calc(13px * var(--k, 1));
        font-weight: 800;
        line-height: 1.15;
        text-overflow: ellipsis;
        white-space: nowrap;
        letter-spacing: -0.01em;
    }

    .course-code {
        display: block;
        margin-top: calc(1.5px * var(--k, 1));
        overflow: hidden;
        color: var(--brand-teal);
        font-size: calc(8.5px * var(--k, 1));
        font-weight: 700;
        letter-spacing: 0.03em;
        text-overflow: ellipsis;
        white-space: nowrap;
        text-transform: uppercase;
    }

    .lecture-not-started .course-code {
        color: #64748b;
    }

    .lecture-waiting .course-code {
        color: #be123c;
    }

    .lecture-cancelled .course-code {
        color: #b91c1c;
    }

    /* --- section badge (top inline-end corner) ----------- */
    .lecture-section {
        flex: 0 0 auto;
        max-width: 46%;
        margin-inline-start: auto;
        display: inline-flex;
        align-items: center;
        gap: calc(4px * var(--k, 1));
        padding: calc(2px * var(--k, 1)) calc(7px * var(--k, 1));
        overflow: hidden;
        border: 1px solid var(--line);
        border-radius: 999px;
        background: #f8fafc;
        color: var(--ink-soft);
        font-size: calc(8.5px * var(--k, 1));
        font-weight: 700;
        line-height: 1.25;
    }

    .lecture-section i {
        flex: 0 0 auto;
        color: var(--brand-lime);
        font-size: calc(8px * var(--k, 1));
    }

    .lecture-section span {
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .lecture-not-started .lecture-section {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: #334155;
    }

    .lecture-not-started .lecture-section i {
        color: #475569;
    }

    .lecture-in-progress .lecture-section {
        background: var(--brand-teal-soft);
        border-color: var(--brand-teal-border);
        color: var(--brand-teal-ink);
    }

    .lecture-in-progress .lecture-section i {
        color: var(--brand-teal);
    }

    .lecture-waiting .lecture-section {
        background: #fff1f2;
        border-color: #fecdd3;
        color: #be123c;
    }

    .lecture-waiting .lecture-section i {
        color: #f43f5e;
    }

    .lecture-cancelled .lecture-section {
        background: #fef2f2;
        border-color: #fecaca;
        color: #b91c1c;
    }

    .lecture-cancelled .lecture-section i {
        color: #ef4444;
    }

    /* --- time -------------------------------------------- */
    .lecture-time {
        flex: 0 0 auto;
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        gap: calc(5px * var(--k, 1));
        margin-top: calc(7px * var(--k, 1));
        padding: calc(5px * var(--k, 1)) calc(8px * var(--k, 1));
        border-radius: calc(7px * var(--k, 1));
        /* background: #f8fafc; */
        /* border: 1px solid var(--line); */
        color: #334155;
        font-size: calc(10px * var(--k, 1));
        font-weight: 600;
    }

    .lecture-not-started .lecture-time {
        /* background: #f8fafc; */
        border-color: #e2e8f0;
        color: #1e293b;
    }

    .lecture-in-progress .lecture-time {
        /* background: #f0fdfa; */
        /* border-color: var(--brand-teal-border); */
        /* color: #0f766e; */
    }

    .lecture-waiting .lecture-time {
        /* background: #fff1f2; */
        /* border-color: #fecdd3; */
        /* color: #9f1239; */
    }

    .lecture-cancelled .lecture-time {
        /* background: #fef2f2; */
        /* border-color: #fecaca; */
        /* color: #991b1b; */
    }

    .time-block {
        min-width: 0;
        display: inline-flex;
        align-items: center;
        gap: calc(5px * var(--k, 1));
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .time-block i {
        color: var(--brand-teal);
        font-size: 0.95em;
    }

    .lecture-not-started .time-block i {
        color: #475569;
    }

    .lecture-waiting .time-block i {
        color: #f43f5e;
    }

    .lecture-cancelled .time-block i {
        color: #ef4444;
    }

    .time-block:last-child {
        justify-content: flex-end;
    }

    .time-separator {
        color: #94a3b8;
        font-weight: 700;
    }

    .lecture-not-started .time-separator {
        color: #94a3b8;
    }

    /* --- details (trainer) ------------------------------- */
    .lecture-details {
        flex: 0 0 auto;
        display: flex;
        align-items: center;
        margin-top: calc(5px * var(--k, 1));
        padding-top: calc(4px * var(--k, 1));
        /* border-top: 1px solid var(--line); */
    }

    .lecture-not-started .lecture-details {
        border-top-color: #e2e8f0;
    }

    .detail-item {
        min-width: 0;
        width: 100%;
        display: flex;
        align-items: center;
        gap: calc(6px * var(--k, 1));
        color: var(--ink-soft);
        font-size: calc(9.5px * var(--k, 1));
        font-weight: 600;
        line-height: 1.15;
    }

    .lecture-not-started .detail-item {
        color: #334155;
    }

    .detail-avatar {
        flex: 0 0 auto;
        width: calc(16px * var(--k, 1));
        height: calc(16px * var(--k, 1));
        display: grid;
        place-items: center;
        border-radius: 50%;
        background: linear-gradient(135deg, #14b8a6, #84cc16);
        color: #ffffff;
        font-size: max(6px, calc(7.5px * var(--k, 1)));
        font-weight: 800;
        letter-spacing: .02em;
        line-height: 1;
    }

    .lecture-not-started .detail-avatar {
        background: linear-gradient(135deg, #475569, #1e293b);
        color: #ffffff;
    }

    .lecture-waiting .detail-avatar {
        background: linear-gradient(135deg, #f43f5e, #fb7185);
    }

    .lecture-cancelled .detail-avatar {
        background: linear-gradient(135deg, #dc2626, #ef4444);
    }

    .detail-text {
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: #1e293b;
    }

    .lecture-not-started .detail-text {
        color: #0f172a;
    }

    .detail-meta {
        flex: 0 0 auto;
        margin-inline-start: auto;
        display: inline-flex;
        align-items: center;
        gap: calc(3px * var(--k, 1));
        padding-inline-start: calc(6px * var(--k, 1));
        color: var(--muted);
        font-size: calc(8.5px * var(--k, 1));
        font-weight: 600;
        font-variant-numeric: tabular-nums;
        white-space: nowrap;
    }

    .detail-meta i {
        color: var(--brand-teal);
    }

    .lecture-not-started .detail-meta i {
        color: #475569;
    }

    .lecture-waiting .detail-meta i {
        color: #f43f5e;
    }

    .lecture-cancelled .detail-meta i {
        color: #ef4444;
    }

    /* --- attendance rate (in progress only) -------------- */
    .lecture-attendance-rate {
        flex: 0 0 auto;
        margin-top: calc(5px * var(--k, 1));
        padding: calc(2px * var(--k, 1)) 0;
        background: transparent;
        color: var(--ink);
    }

    .attendance-rate-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: calc(8px * var(--k, 1));
        margin-bottom: calc(3px * var(--k, 1));
        color: var(--muted);
        font-size: calc(8.5px * var(--k, 1));
        font-weight: 700;
        letter-spacing: .03em;
        line-height: 1.1;
        text-transform: uppercase;
    }

    .attendance-rate-header [data-attendance-rate] {
        color: #15803d;
        font-size: calc(10px * var(--k, 1));
        font-weight: 800;
        font-variant-numeric: tabular-nums;
    }

    .attendance-rate-track {
        height: calc(4px * var(--k, 1));
        overflow: hidden;
        border-radius: 999px;
        background: #e2e8f0;
    }

    .attendance-rate-fill {
        width: 0;
        height: 100%;
        border-radius: inherit;
        background: linear-gradient(90deg, #14b8a6, #84cc16);
    }

    /* --- live timeline ----------------------------------- */
    .lecture-timeline {
        flex: 0 0 auto;
        margin-top: calc(4px * var(--k, 1));
    }

    .timeline-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: calc(8px * var(--k, 1));
        margin-bottom: calc(2px * var(--k, 1));
        color: var(--muted);
        font-size: calc(8.5px * var(--k, 1));
        font-weight: 600;
        line-height: 1.1;
    }

    .timeline-header [data-remaining] {
        color: #0f172a;
        font-size: calc(9.5px * var(--k, 1));
        font-weight: 700;
        font-variant-numeric: tabular-nums;
        white-space: nowrap;
    }

    .lecture-in-progress .timeline-header [data-remaining] {
        color: var(--brand-teal);
    }

    .lecture-waiting .timeline-header [data-remaining] {
        color: #e11d48;
    }

    .timeline-track {
        width: 100%;
        height: calc(4px * var(--k, 1));
        overflow: hidden;
        border-radius: 999px;
        background: #e2e8f0;
    }

    .timeline-fill {
        width: 0;
        height: 100%;
        border-radius: inherit;
        background: linear-gradient(90deg, #14b8a6, #84cc16);
        transition: width .5s linear;
    }

    .lecture-waiting .timeline-fill {
        background: linear-gradient(90deg, #f43f5e, #fb7185);
    }

    /* ==========================================================
       ROOM CARDS
    ========================================================== */
    .room-card {
        width: 100%;
        min-width: 0;

        height: auto;
        min-height: max-content;

        padding: calc(8px * var(--rk, 1)) calc(10px * var(--rk, 1));
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: calc(4px * var(--rk, 1));
        overflow: hidden;
        background: linear-gradient(180deg, #bcf5e7 0%, #ffffff 100%);
        border: 1px solid #a9ece5;
        border-radius: clamp(15px, calc(15px * var(--rk, 1)), 10px);
        box-shadow: var(--shadow-card);
        line-height: 1.15;
        transition: transform .2s ease, border-color .2s ease, box-shadow .2s ease;
        color: var(--ink);
    }

    .rooms-container {
        display: grid;
        gap: 16px;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        align-items: start;
        justify-content: start;
    }

    .room-card:hover {
        transform: translateY(-2px);
        /* border-color: #65a30d; */
        /* border-style: solid; */
        box-shadow: 0 8px 20px rgba(20, 184, 166, 0.12);
    }

    .room-header {
        min-width: 0;
        display: flex;
        align-items: center;
        gap: calc(8px * var(--rk, 1));
    }

    .room-icon {
        width: calc(28px * var(--rk, 1));
        height: calc(28px * var(--rk, 1));
        min-width: calc(16px * var(--rk, 1));
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: calc(6px * var(--rk, 1));
        background: var(--brand-teal-soft);
        border: 1px solid var(--brand-teal-border);
    }

    .room-icon i {
        color: var(--brand-teal);
        font-size: calc(13px * var(--rk, 1));
    }

    .room-code {
        max-width: 100%;
        overflow: hidden;
        color: #0f172a;
        font-size: calc(14px * var(--rk, 1));
        font-weight: 800;
        text-overflow: ellipsis;
        white-space: nowrap;
        letter-spacing: -0.01em;
    }

    .room-status {
        max-width: 100%;
        overflow: hidden;
        color: var(--brand-teal);
        font-size: calc(10px * var(--rk, 1));
        font-weight: 700;
        text-overflow: ellipsis;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .room-status i {
        font-size: 0.9em;
    }

    .room-free {
        max-width: 100%;
        flex: 0 0 auto;
        padding: calc(2px * var(--rk, 1)) calc(8px * var(--rk, 1));
        /* background: var(--brand-lime-soft); */
        /* border: 1px solid var(--brand-lime-border); */
        border-radius: 999px;
        /* color: #4d7c0f; */
        font-size: calc(9px * var(--rk, 1));
        font-weight: 800;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        letter-spacing: 0.02em;
    }

    /* ==========================================================
       MODAL (DRAWER)
    ========================================================== */
    .lecture-modal {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: none;
        align-items: stretch;
        justify-content: flex-end;
        background: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
    }

    .lecture-modal.active {
        display: flex;
    }

    .modal-panel {
        width: min(500px, 100vw);
        max-width: 100vw;
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        background: #ffffff;
        border-left: 1px solid var(--line);
        box-shadow: -15px 0 45px rgba(0, 0, 0, 0.12);
        scrollbar-gutter: stable;
        animation: slideIn .25s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
        }

        to {
            transform: translateX(0);
        }
    }

    .modal-header {
        flex: 0 0 auto;
        min-height: 85px;
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 18px 22px;
        background: #ffffff;
        color: #0f172a;
        border-bottom: 1px solid var(--line);
        position: relative;
    }

    .modal-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, #14b8a6, #84cc16);
    }

    .modal-header.waiting::after {
        background: linear-gradient(90deg, #f43f5e, #fb7185);
    }

    .modal-header.cancelled::after {
        background: #ef4444;
    }

    .modal-header-left {
        flex: 1;
        min-width: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .modal-icon {
        width: 44px;
        height: 44px;
        min-width: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--brand-teal-border);
        border-radius: 12px;
        background: var(--brand-teal-soft);
    }

    .modal-icon i {
        color: var(--brand-teal);
        font-size: 20px;
    }

    .modal-header.waiting .modal-icon {
        background: #fff1f2;
        border-color: #fecdd3;
    }

    .modal-header.waiting .modal-icon i {
        color: #e11d48;
    }

    .modal-header.cancelled .modal-icon {
        background: #fef2f2;
        border-color: #fecaca;
    }

    .modal-header.cancelled .modal-icon i {
        color: #dc2626;
    }

    .modal-title {
        max-width: 230px;
        margin: 0;
        overflow: hidden;
        color: #0f172a;
        font-size: 17px;
        font-weight: 800;
        line-height: 1.2;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .modal-trainer {
        max-width: 230px;
        margin-top: 4px;
        overflow: hidden;
        color: var(--muted);
        font-size: 11px;
        font-weight: 600;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .modal-course {
        flex: 0 0 auto;
        max-width: 92px;
        overflow: hidden;
        color: #4d7c0f;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .04em;
        text-align: right;
        text-overflow: ellipsis;
        text-transform: uppercase;
        white-space: nowrap;
        background: var(--brand-lime-soft);
        padding: 4px 8px;
        border-radius: 6px;
        border: 1px solid var(--brand-lime-border);
    }

    .modal-close {
        flex: 0 0 36px;
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--line);
        border-radius: 9px;
        background: #f8fafc;
        color: var(--ink-soft);
        font-size: 15px;
        cursor: pointer;
        transition: all .2s ease;
    }

    .modal-close:hover {
        background: #fee2e2;
        border-color: #fca5a5;
        color: #dc2626;
        transform: scale(1.05);
    }

    .modal-close:focus-visible {
        outline: 2px solid var(--brand-teal);
        outline-offset: 2px;
    }

    .modal-body {
        flex: 1 1 auto;
        min-height: 0;
        padding: 22px;
        overflow-y: auto;
        background: #f8fafc;
    }

    .modal-status-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 18px;
        padding-bottom: 14px;
        border-bottom: 1px solid var(--line);
    }

    .modal-status {
        display: inline-block;
        padding: 5px 13px;
        background: var(--brand-teal-soft);
        border: 1px solid var(--brand-teal-border);
        border-radius: 999px;
        color: var(--brand-teal-ink);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .02em;
        text-transform: uppercase;
    }

    .modal-header.waiting+.modal-body .modal-status {
        background: #fff1f2;
        border-color: #fecdd3;
        color: #e11d48;
    }

    .modal-header.cancelled+.modal-body .modal-status {
        background: #fef2f2;
        border-color: #fecaca;
        color: #dc2626;
    }

    .modal-time {
        color: var(--ink-soft);
        font-size: 12px;
        font-weight: 700;
        font-variant-numeric: tabular-nums;
    }

    .details-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        margin-bottom: 16px;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid var(--line);
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    }

    .detail-box {
        min-width: 0;
        padding: 14px 12px;
        border-right: 1px solid var(--line);
    }

    .detail-box:last-child {
        border-right: 0;
    }

    .detail-label {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 6px;
        color: var(--muted);
        font-size: 9.5px;
        font-weight: 700;
        letter-spacing: .05em;
        text-transform: uppercase;
    }

    .detail-label i {
        color: var(--brand-teal);
    }

    .detail-value {
        display: block;
        overflow: hidden;
        color: #0f172a;
        font-size: 12px;
        font-weight: 700;
        line-height: 1.3;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .info-row {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid var(--line);
    }

    .info-icon {
        width: 32px;
        height: 32px;
        min-width: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--brand-teal-border);
        border-radius: 8px;
        background: var(--brand-teal-soft);
        color: var(--brand-teal);
        font-size: 13px;
    }

    .info-label {
        margin-bottom: 3px;
        color: var(--muted);
        font-size: 9.5px;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .info-value {
        color: #0f172a;
        font-size: 12px;
        font-weight: 600;
        word-break: break-word;
    }

    .attendance-details {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 8px;
        margin-top: 18px;
    }

    .attendance-box {
        min-height: 64px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 10px 4px;
        background: #ffffff;
        border: 1px solid var(--line);
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
        transition: border-color .2s ease;
    }

    .attendance-box:hover {
        border-color: var(--brand-teal-light);
    }

    .attendance-number {
        display: block;
        color: #0f172a;
        font-size: 17px;
        font-weight: 800;
        font-variant-numeric: tabular-nums;
    }

    .attendance-box:nth-child(2) .attendance-number {
        color: var(--brand-teal);
    }

    .attendance-box:nth-child(3) .attendance-number {
        color: var(--danger);
    }

    .attendance-box:nth-child(4) .attendance-number {
        color: #f43f5e;
    }

    .attendance-label {
        display: block;
        margin-top: 4px;
        color: var(--muted);
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .attendance-percentage {
        margin-top: 18px;
        padding: 16px;
        background: #ffffff;
        border: 1px solid var(--brand-teal-border);
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(13, 148, 136, 0.08);
    }

    .attendance-percentage-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .attendance-percentage-label {
        color: var(--muted);
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .attendance-percentage-value {
        color: #15803d;
        font-size: 22px;
        font-weight: 800;
        font-variant-numeric: tabular-nums;
    }

    .attendance-progress {
        width: 100%;
        height: 7px;
        overflow: hidden;
        border-radius: 999px;
        background: #e2e8f0;
    }

    .attendance-progress-value {
        width: 0%;
        height: 100%;
        border-radius: inherit;
        background: linear-gradient(90deg, #14b8a6, #84cc16);
        transition: width .4s ease;
    }

    .attendance-students {
        margin-top: 18px;
        padding: 16px;
        background: #ffffff;
        border: 1px solid var(--line);
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    }

    .attendance-students-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .attendance-students-title {
        display: flex;
        align-items: center;
        gap: 7px;
        color: #0f172a;
        font-size: 11.5px;
        font-weight: 800;
        text-transform: uppercase;
    }

    .attendance-students-title i {
        color: var(--danger);
    }

    .attendance-students-count {
        min-width: 26px;
        height: 26px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 6px;
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 50%;
        color: #dc2626;
        font-size: 10px;
        font-weight: 800;
        font-variant-numeric: tabular-nums;
    }

    .attendance-students-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
        min-height: 76px;
        max-height: 260px;
        overflow-y: auto;
    }

    .attendance-student {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 10px 12px;
        background: #f8fafc;
        border: 1px solid var(--line);
        border-radius: 8px;
    }

    .student-info {
        flex: 1;
        min-width: 0;
    }

    .student-name {
        color: #0f172a;
        font-size: 11px;
        font-weight: 700;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .student-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 4px;
    }

    .student-meta-item {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        color: var(--muted);
        font-size: 9px;
        font-weight: 600;
    }

    .student-meta-item i {
        font-size: 8px;
        color: var(--brand-teal);
    }

    .student-status {
        flex-shrink: 0;
        padding: 3px 8px;
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 4px;
        color: #dc2626;
        font-size: 8.5px;
        font-weight: 800;
        text-transform: uppercase;
    }

    .attendance-loading {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 25px 10px;
        color: var(--muted);
        font-size: 10.5px;
        font-weight: 600;
    }

    .attendance-loading i {
        color: var(--brand-teal);
    }

    .attendance-empty {
        padding: 20px 10px;
        color: var(--muted);
        font-size: 11px;
        font-weight: 600;
        text-align: center;
    }

    .attendance-empty i {
        display: block;
        margin-bottom: 7px;
        color: var(--brand-teal);
        font-size: 22px;
    }

    .time-summary {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-top: 18px;
        padding: 16px;
        background: #ffffff;
        border: 1px solid var(--line);
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    }

    .time-summary-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .time-summary-icon {
        color: var(--brand-teal);
        font-size: 20px;
    }

    .time-summary-label {
        color: var(--muted);
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .time-summary-value {
        margin-top: 2px;
        color: #0f172a;
        font-size: 22px;
        font-weight: 800;
        font-variant-numeric: tabular-nums;
    }

    .duration {
        text-align: right;
    }

    .duration-label {
        color: var(--muted);
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .duration-value {
        margin-top: 3px;
        color: #15803d;
        font-size: 12px;
        font-weight: 800;
    }

    /* --- status tinted time summary ---------------------- */
    .modal-header.waiting+.modal-body .time-summary {
        background: #fff1f2;
        border-color: #fecdd3;
    }

    .modal-header.waiting+.modal-body .time-summary-icon,
    .modal-header.waiting+.modal-body .time-summary-value {
        color: #e11d48;
    }

    .modal-header.cancelled+.modal-body .time-summary {
        background: #fef2f2;
        border-color: #fecaca;
    }

    .modal-header.cancelled+.modal-body .time-summary-icon,
    .modal-header.cancelled+.modal-body .time-summary-value {
        color: #dc2626;
    }

    /* ==========================================================
       DENSITY TIERS
    ========================================================== */
    .lectures-grid[data-density="tight"] .lecture-details {
        display: none;
    }

    .lectures-grid[data-density="ultra"] .lecture-details,
    .lectures-grid[data-density="ultra"] .lecture-attendance-rate,
    .lectures-grid[data-density="ultra"] .lecture-timeline {
        display: none;
    }

    .rooms-grid[data-density="ultra"] .room-free {
        display: none;
    }

    /* ==========================================================
       RESPONSIVE
    ========================================================== */
    @media (max-width: 720px) {
        .dashboard-header {
            align-items: flex-start;
            flex-direction: column;
            gap: 8px;
        }

        .dashboard-summary {
            justify-content: flex-start;
            width: 100%;
        }

        .modal-header {
            min-height: 80px;
            padding: 16px;
        }

        .modal-body {
            padding: 16px;
        }

        .modal-title,
        .modal-trainer {
            max-width: 160px;
        }

        .modal-course {
            max-width: 72px;
        }
    }

    @media (max-width: 600px) {
        .details-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .detail-box:nth-child(2) {
            border-right: 0;
        }

        .detail-box:nth-child(3) {
            grid-column: 1 / -1;
            border-top: 1px solid var(--line);
            border-right: 0;
        }

        .attendance-details {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 480px) {
        :root {
            --top-bar: 4px;
        }

        .dashboard-wrapper {
            padding: 6px;
        }

        .dashboard-summary {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .dashboard-summary .total-badge {
            min-width: 0;
            justify-content: center;
            padding: 5px 6px;
            white-space: normal;
        }

        .attendance-student {
            align-items: flex-start;
            flex-direction: column;
        }

        .student-status {
            align-self: flex-start;
        }

        .modal-panel {
            width: 100%;
            max-width: 100%;
        }
    }

    @media (max-width: 360px) {
        .modal-header {
            gap: 10px;
        }

        .modal-course {
            display: none;
        }

        .attendance-details {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (prefers-reduced-motion: reduce) {

        .lecture-card,
        .modal-panel,
        .modal-close,
        .timeline-fill,
        .attendance-progress-value {
            animation: none;
            transition: none;
        }

        .lecture-card:hover,
        .modal-close:hover {
            transform: none;
        }
    }

    /* ==========================================================
       AVAILABLE TRAINERS MODAL & BADGE
    ========================================================== */
    .trainer-badge-btn {
        cursor: pointer;
        user-select: none;
        outline: none;
    }

    .trainer-badge-btn:hover {
        border-color: #84cc16;
        box-shadow: 0 4px 12px rgba(132, 204, 22, 0.2);
        transform: translateY(-2px);
    }

    .trainers-modal {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 16px;
        background: rgba(15, 23, 42, 0.45);
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
    }

    .trainers-modal.active {
        display: flex;
    }

    .trainers-modal-panel {
        width: min(520px, 100%);
        max-height: 85vh;
        display: flex;
        flex-direction: column;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.2), 0 0 0 1px var(--line);
        overflow: hidden;
        animation: trainerModalPop .22s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes trainerModalPop {
        from {
            opacity: 0;
            transform: scale(0.95) translateY(8px);
        }

        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .trainers-modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        background: #ffffff;
        border-bottom: 1px solid var(--line);
        position: relative;
    }

    .trainers-modal-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, #84cc16, #14b8a6);
    }

    .trainers-modal-title-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .trainers-modal-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: var(--brand-lime-soft);
        border: 1px solid var(--brand-lime-border);
        color: #4d7c0f;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .trainers-modal-title {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        line-height: 1.2;
    }

    .trainers-modal-subtitle {
        font-size: 11.5px;
        font-weight: 600;
        color: var(--muted);
        margin-top: 2px;
    }

    .trainers-modal-body {
        flex: 1;
        overflow-y: auto;
        padding: 16px 20px;
        background: #f8fafc;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .trainer-card-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 14px;
        background: #ffffff;
        border: 1px solid var(--line);
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        transition: all 0.2s ease;
    }

    .trainer-card-item:hover {
        border-color: #84cc16;
        box-shadow: 0 3px 8px rgba(132, 204, 22, 0.12);
        transform: translateY(-1px);
    }

    .trainer-info {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    .trainer-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        border: 1px solid #bbf7d0;
        color: #15803d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 800;
        flex-shrink: 0;
    }

    .trainer-details {
        min-width: 0;
    }

    .trainer-name {
        font-size: 13.5px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .trainer-email {
        font-size: 12px;
        font-weight: 500;
        color: var(--muted);
        margin-top: 2px;
        display: flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .trainer-email a {
        color: var(--ink-soft);
        text-decoration: none;
        transition: color 0.2s;
    }

    .trainer-email a:hover {
        color: var(--brand-teal);
        text-decoration: underline;
    }

    .trainer-badge-tag {
        font-size: 10.5px;
        font-weight: 700;
        padding: 3px 8px;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #047857;
        border-radius: 999px;
        white-space: nowrap;
        text-transform: capitalize;
    }

    .trainers-empty {
        text-align: center;
        padding: 30px 10px;
        color: var(--muted);
        font-size: 13px;
        font-weight: 600;
    }

    .trainers-empty i {
        font-size: 28px;
        color: #cbd5e1;
        margin-bottom: 8px;
        display: block;
    }
</style>
