<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Today's Lectures & Rooms</title>




    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


    @include('partials.dashboard-styles')
</head>


<body>



    <main class="dashboard-wrapper">


        {{-- =========================================================
         HEADER
    ========================================================== --}}

        <div class="dashboard-header">

            <div>

                <h1 class="dashboard-title">
                    Today's Lectures & Rooms
                </h1>

                <div class="dashboard-date">
                    {{ $dashboardDate }}
                </div>

            </div>


            <div class="dashboard-summary" aria-label="Today's availability">
                <div class="total-badge" id="totalCount" aria-live="polite">
                    <i class="fas fa-chart-pie" aria-hidden="true"></i>
                    Total: {{ $lectures->count() + $availableRooms->count() }}
                </div>

                <div class="total-badge">
                    <i class="fas fa-user-tie" aria-hidden="true"></i>
                    Available trainers
                    <strong class="summary-value" id="availableTrainersCount" aria-live="polite">
                        {{ $availableTrainerCount }}
                    </strong>
                </div>

                <div class="total-badge">
                    <i class="fas fa-door-open" aria-hidden="true"></i>
                    Available rooms
                    <strong class="summary-value" id="availableRoomsHeaderCount" aria-live="polite">
                        {{ $availableRooms->count() }}
                    </strong>
                </div>
            </div>

        </div>

        <div class="dashboard-content">
            <section class="dashboard-section lectures-section">

                {{-- =========================================================
         LECTURES HEADER
    ========================================================== --}}

                <div class="section-header">

                    <div class="section-title">

                        <i class="fas fa-laptop-code" style="color: var(--blue);" aria-hidden="true"></i>

                        Today's Lectures

                    </div>


                    <div class="section-count" id="lecturesCount" aria-live="polite">

                        {{ $lectures->count() }}

                        Lectures

                    </div>

                </div>


                {{-- =========================================================
         LECTURES
    ========================================================== --}}

                <div class="lectures-grid" id="lecturesGrid">

                    @include('partials.lectures-grid', [
                        'lectures' => $lectures,
                    ])

                </div>
            </section>

            <section class="dashboard-section rooms-section">

                {{-- =========================================================
         AVAILABLE ROOMS
    ========================================================== --}}

                <div class="section-header">

                    <div class="section-title">

                        <i class="fas fa-compass" style="color: var(--teal);" aria-hidden="true"></i>

                        Available Rooms

                    </div>


                    <div class="section-count" id="roomsCount" aria-live="polite">

                        {{ $availableRooms->count() }}

                        Rooms

                    </div>

                </div>


                <div class="rooms-grid" id="roomsGrid">

                    @include('partials.room-grid', [
                        'availableRooms' => $availableRooms,
                    ])
                </div>
            </section>
        </div>


    </main>


    
    @include('partials.dashboard-layout')



 

    <div class="lecture-modal" id="lectureModal" role="dialog" aria-modal="true" aria-labelledby="lectureModalTitle"
        aria-hidden="true">


        <div class="modal-panel">


            <div class="modal-header not-started" data-modal-header>
                <div class="modal-header-left">
                    <div class="modal-icon">
                        <i class="fas fa-graduation-cap" aria-hidden="true"></i>
                    </div>
                    <div>
                        <div class="modal-title" id="lectureModalTitle" data-modal-batch>-</div>
                        <div class="modal-trainer" data-modal-trainer>-</div>
                    </div>
                </div>
                <div class="modal-course" data-modal-course>-</div>
                <button type="button" class="modal-close" id="closeLectureModal" aria-label="Close lecture details">
                    <i class="fas fa-times" aria-hidden="true"></i>
                </button>
            </div>

            <div class="modal-body" role="region" tabindex="0" aria-label="Lecture details">


                <div class="modal-status-row">


                    <div class="modal-status" data-modal-status aria-live="polite">
                        Not Started
                    </div>


                    <div class="modal-time" data-modal-time aria-live="polite">
                        -
                    </div>


                </div>


                {{-- DETAILS --}}

                <div class="details-grid">


                    <div class="detail-box">

                        <span class="detail-label">

                            <i class="fas fa-door-open"></i>

                            Room

                        </span>


                        <span class="detail-value" data-modal-room>
                            -
                        </span>

                    </div>


                    <div class="detail-box">

                        <span class="detail-label">

                            <i class="fas fa-desktop"></i>

                            Delivery Mode

                        </span>


                        <span class="detail-value" data-modal-delivery>
                            -
                        </span>

                    </div>


                    <div class="detail-box">

                        <span class="detail-label">

                            <i class="fas fa-user"></i>

                            Trainer

                        </span>


                        <span class="detail-value" data-modal-trainer-2>
                            -
                        </span>

                    </div>


                </div>


                {{-- ONLINE LINK --}}

                <div class="info-row" data-online-row style="display:none;">

                    <div class="info-icon">

                        <i class="fas fa-video"></i>

                    </div>


                    <div>

                        <div class="info-label">

                            Online Meeting

                        </div>


                        <div class="info-value" data-modal-online-link>
                            -
                        </div>

                    </div>

                </div>


                {{-- COURSE --}}

                <div class="info-row">


                    <div class="info-icon">

                        <i class="fas fa-book"></i>

                    </div>


                    <div>

                        <div class="info-label">
                            Course
                        </div>


                        <div class="info-value" data-modal-course-full>
                            -
                        </div>

                    </div>


                </div>


                {{-- BATCH --}}

                <div class="info-row">


                    <div class="info-icon">

                        <i class="fas fa-users"></i>

                    </div>


                    <div>

                        <div class="info-label">
                            Batch
                        </div>


                        <div class="info-value" data-modal-batch-full>
                            -
                        </div>

                    </div>


                </div>


                {{-- SECTION --}}

                <div class="info-row">


                    <div class="info-icon">

                        <i class="fas fa-layer-group"></i>

                    </div>


                    <div>

                        <div class="info-label">
                            Trainee Section
                        </div>


                        <div class="info-value" data-modal-section>
                            -
                        </div>

                    </div>


                </div>


                {{-- ATTENDANCE --}}

                <div class="attendance-details">


                    <div class="attendance-box">

                        <span class="attendance-number" data-modal-trainees>
                            0
                        </span>

                        <span class="attendance-label">
                            Trainees
                        </span>

                    </div>


                    <div class="attendance-box">

                        <span class="attendance-number" data-modal-present>
                            0
                        </span>

                        <span class="attendance-label">
                            Present
                        </span>

                    </div>


                    <div class="attendance-box">

                        <span class="attendance-number" data-modal-absent>
                            0
                        </span>

                        <span class="attendance-label">
                            Absent
                        </span>

                    </div>


                    <div class="attendance-box">

                        <span class="attendance-number" data-modal-late>
                            0
                        </span>

                        <span class="attendance-label">
                            Late
                        </span>

                    </div>


                    <div class="attendance-box">

                        <span class="attendance-number" data-modal-excused>
                            0
                        </span>

                        <span class="attendance-label">
                            Excused
                        </span>

                    </div>


                </div>


                {{-- ATTENDANCE % --}}

                <div class="attendance-percentage">


                    <div class="attendance-percentage-top">

                        <span class="attendance-percentage-label">

                            Attendance Rate

                        </span>


                        <span class="attendance-percentage-value" data-modal-attendance-percentage>

                            0%

                        </span>

                    </div>


                    <div class="attendance-progress">

                        <div class="attendance-progress-value" data-modal-attendance-progress></div>

                    </div>


                </div>


                {{-- ABSENT TRAINEES --}}

                <div class="attendance-students">


                    <div class="attendance-students-header">


                        <div class="attendance-students-title">

                            <i class="fas fa-user-times"></i>

                            Absent Trainees

                        </div>


                        <div class="attendance-students-count" data-modal-attendance-count>
                            0
                        </div>


                    </div>


                    <div class="attendance-students-list" data-modal-attendance-list>

                        <div class="attendance-loading">

                            <i class="fas fa-spinner fa-spin"></i>

                            Loading absent trainees...

                        </div>

                    </div>


                </div>


                {{-- TIME --}}

                <div class="time-summary">


                    <div class="time-summary-left">


                        <div class="time-summary-icon">

                            <i class="far fa-clock"></i>

                        </div>


                        <div>

                            <div class="time-summary-label">

                                <span data-time-label>
                                    Starts In
                                </span>

                            </div>


                            <div class="time-summary-value" data-modal-remaining aria-live="polite">
                                --:--:--
                            </div>

                        </div>


                    </div>


                    <div class="duration">

                        <div class="duration-label">

                            Duration

                        </div>


                        <div class="duration-value" data-modal-duration>
                            -
                        </div>

                    </div>


                </div>


            </div>


        </div>


    </div>



    <script>
        /* ============================================================
                           VARIABLES
                        ============================================================ */

        const lectureModal = document.getElementById('lectureModal');
        const closeLectureModal = document.getElementById('closeLectureModal');
        let selectedLecture = null;
        let lastFocusedLecture = null;
        let attendanceBySchedule = {};

        function parseDateTime(value) {
            if (!value) {
                return null;
            }

            return new Date(value.trim().replace(' ', 'T'));
        }

        function formatRemaining(seconds) {
            seconds = Math.max(0, Math.floor(seconds));

            const hours = Math.floor(seconds / 3600);
            const minutes = Math.floor((seconds % 3600) / 60);
            const remainingSeconds = seconds % 60;

            return String(hours).padStart(2, '0') + ':' +
                String(minutes).padStart(2, '0') + ':' +
                String(remainingSeconds).padStart(2, '0');
        }

        /* ============================================================
           VISUAL STATE
        ============================================================ */

        function getVisualState(
            status,
            start,
            end,
            now
        ) {

            if (
                status === 'cancelled'
            ) {
                return 'cancelled';
            }

            if (
                status === 'in_progress'
            ) {
                return 'in_progress';
            }

            if (
                status === 'finished'
            ) {
                return 'finished';
            }

            if (
                status === 'not_started' &&
                now >= start &&
                now < end
            ) {
                return 'waiting';
            }

            return 'not_started';
        }


        /* ============================================================
           APPLY CARD STATE
        ============================================================ */

        function applyCardState(
            card,
            state
        ) {

            card.classList.remove(
                'lecture-not-started',
                'lecture-waiting',
                'lecture-in-progress',
                'lecture-finished',
                'lecture-cancelled'
            );


            if (
                state === 'not_started'
            ) {

                card.classList.add(
                    'lecture-not-started'
                );

            } else if (
                state === 'waiting'
            ) {

                card.classList.add(
                    'lecture-waiting'
                );

            } else if (
                state === 'in_progress'
            ) {

                card.classList.add(
                    'lecture-in-progress'
                );

            } else if (
                state === 'cancelled'
            ) {

                card.classList.add(
                    'lecture-cancelled'
                );

            } else {

                card.classList.add(
                    'lecture-finished'
                );
            }
        }


        /* ============================================================
           UPDATE CARD
        ============================================================ */

        function updateLectureCard(card) {

            const status =
                card.dataset.status;


            const start =
                parseDateTime(
                    card.dataset.start
                );


            const end =
                parseDateTime(
                    card.dataset.end
                );


            if (
                !start ||
                !end
            ) {

                return;
            }


            const now =
                new Date();


            const state =
                getVisualState(
                    status,
                    start,
                    end,
                    now
                );

            if (
                status === 'cancelled' &&
                now >= end
            ) {
                card.style.display = 'none';
                return;
            }

            card.style.display = '';

            applyCardState(
                card,
                state
            );


            const timelineLabels = {
                not_started: 'Starts in',
                waiting: '',
                in_progress: 'Time remaining',
                finished: 'Finished',
                cancelled: ''
            };

            const total =
                end.getTime() -
                start.getTime();

            let progressPercent = 0;
            let remainingSeconds = 0;

            if (
                state === 'not_started'
            ) {
                remainingSeconds =
                    (
                        start.getTime() -
                        now.getTime()
                    ) / 1000;

            } else if (
                state === 'waiting'
            ) {
                remainingSeconds =
                    (
                        end.getTime() -
                        now.getTime()
                    ) / 1000;

            } else if (
                state === 'cancelled'
            ) {
                remainingSeconds = 0;

            } else if (
                state === 'in_progress' &&
                total > 0
            ) {
                const elapsed =
                    now.getTime() -
                    start.getTime();

                progressPercent =
                    (
                        elapsed /
                        total
                    ) * 100;

                remainingSeconds =
                    (
                        end.getTime() -
                        now.getTime()
                    ) / 1000;

            } else if (
                state === 'finished'
            ) {
                progressPercent = 100;
                remainingSeconds = 0;
            } else if (
                state === 'cancelled'
            ) {
                progressPercent = 0;
                remainingSeconds = 0;
            }

            progressPercent =
                Math.min(
                    100,
                    Math.max(
                        0,
                        progressPercent
                    )
                );

            const timelineLabel =
                card.querySelector(
                    '[data-timeline-label]'
                );

            if (timelineLabel) {
                timelineLabel.textContent =
                    timelineLabels[state];
            }

            const progress =
                card.querySelector(
                    '[data-progress]'
                );

            if (progress) {
                progress.style.width =
                    progressPercent + '%';
            }

            const progressTrack =
                card.querySelector(
                    '[role="progressbar"]'
                );

            if (progressTrack) {
                progressTrack.setAttribute(
                    'aria-valuenow',
                    String(Math.round(progressPercent))
                );
                progressTrack.setAttribute(
                    'aria-label',
                    'Lecture ' +
                    (timelineLabels[state] || 'countdown').toLowerCase()
                );
            }

            const remaining =
                card.querySelector(
                    '[data-remaining]'
                );

            if (remaining) {
                remaining.textContent =
                    formatRemaining(
                        remainingSeconds
                    );
            }


            /* ========================================================
               MODAL TIME
            ======================================================== */

            if (
                selectedLecture === card
            ) {

                updateModalTime(
                    card
                );
            }
        }


        /* ============================================================
           UPDATE ALL LECTURES
        ============================================================ */

        function updateLectures() {

            document
                .querySelectorAll(
                    '[data-lecture-card]'
                )
                .forEach(
                    function(card) {

                        updateLectureCard(
                            card
                        );

                    }
                );
        }


        /* ============================================================
           REFRESH LECTURES DATA

           Called by Pusher
        ============================================================ */

        async function refreshLectures() {

            try {

                console.log('Refreshing lectures...');

                const response = await fetch(
                    '/lectures/data', {
                        method: 'GET',

                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },

                        cache: 'no-store'
                    }
                );

                if (!response.ok) {

                    throw new Error(
                        'Failed to load lectures.'
                    );
                }

                const result = await response.json();

                console.log(
                    'Updated dashboard:',
                    result
                );

                renderDashboardItems(result);

            } catch (error) {

                console.error(
                    'Refresh Lectures Error:',
                    error
                );
            }
        }


        /* ============================================================
           RENDER DASHBOARD

           Laravel returns rendered Blade HTML.
           JavaScript only replaces the grids.
        ============================================================ */

        function renderDashboardItems(result) {

            console.log(
                'Rendering dashboard:',
                result
            );

            if (result.attendance_by_schedule !== undefined) {
                attendanceBySchedule = result.attendance_by_schedule || {};
            }

            const lecturesGrid =
                document.getElementById('lecturesGrid');

            const roomsGrid =
                document.getElementById('roomsGrid');


            /* ========================================================
               CHECK SELECTED MODAL LECTURE
            ======================================================== */

            let selectedScheduleId = null;

            if (selectedLecture) {

                selectedScheduleId =
                    selectedLecture.dataset.scheduleId;
            }


            if (
                selectedScheduleId &&
                result.lectures_html !== undefined &&
                !result.lectures_html.includes(
                    `data-schedule-id="${selectedScheduleId}"`
                )
            ) {

                closeModal();
            }


            /* ========================================================
               LECTURES
            ======================================================== */

            if (
                lecturesGrid &&
                result.lectures_html !== undefined
            ) {

                lecturesGrid.innerHTML =
                    result.lectures_html;
            }


            /* ========================================================
               AVAILABLE ROOMS
            ======================================================== */

            if (
                roomsGrid &&
                result.rooms_html !== undefined
            ) {

                roomsGrid.innerHTML =
                    result.rooms_html;
            }


            /* ========================================================
               COUNTERS
            ======================================================== */

            const lecturesCount =
                document.getElementById('lecturesCount');

            const roomsCount =
                document.getElementById('roomsCount');

            const availableTrainersCount =
                document.getElementById('availableTrainersCount');

            const availableRoomsHeaderCount =
                document.getElementById('availableRoomsHeaderCount');

            const totalCount =
                document.getElementById('totalCount');


            if (
                lecturesCount &&
                result.lectures_count !== undefined
            ) {

                lecturesCount.textContent =
                    result.lectures_count + ' Lectures';
            }

            if (
                roomsCount &&
                result.rooms_count !== undefined
            ) {

                roomsCount.textContent =
                    result.rooms_count + ' Rooms';
            }

            if (
                availableRoomsHeaderCount &&
                result.rooms_count !== undefined
            ) {
                availableRoomsHeaderCount.textContent = result.rooms_count;
            }

            if (
                availableTrainersCount &&
                result.available_trainers_count !== undefined
            ) {
                availableTrainersCount.textContent = result.available_trainers_count;
            }

            if (
                totalCount &&
                result.total_count !== undefined
            ) {

                totalCount.innerHTML =
                    '<i class="fas fa-layer-group"></i> ' +
                    'Total: ' +
                    result.total_count;
            }

            if (
                selectedScheduleId &&
                lectureModal.classList.contains('active')
            ) {
                const refreshedCard = Array.from(
                    lecturesGrid.querySelectorAll('[data-lecture-card]')
                ).find(function(card) {
                    return card.dataset.scheduleId === selectedScheduleId;
                });

                if (refreshedCard) {
                    selectedLecture = refreshedCard;
                    lastFocusedLecture = refreshedCard;
                    populateLectureModal(refreshedCard, false);
                } else {
                    closeModal();
                }
            }


            /* ========================================================
               RE-ATTACH CARD EVENTS
            ======================================================== */

            attachLectureCardEvents();


            /* ========================================================
               RE-PLAN GRID (item count may have changed)
            ======================================================== */

            if (window.requestDashboardFit) {
                window.requestDashboardFit();
            }


            /* ========================================================
               UPDATE TIME / PROGRESS
            ======================================================== */

            updateLectures();


            console.log(
                'Dashboard rendered successfully.'
            );
        }


        /* ============================================================
           UPDATE MODAL TIME
        ============================================================ */

        function updateModalTime(card) {

            if (!card) {

                return;
            }


            const start =
                parseDateTime(
                    card.dataset.start
                );


            const end =
                parseDateTime(
                    card.dataset.end
                );


            if (
                !start ||
                !end
            ) {

                return;
            }


            const now =
                new Date();


            const status =
                card.dataset.status;


            const state =
                getVisualState(
                    status,
                    start,
                    end,
                    now
                );


            const remainingElement =
                document.querySelector(
                    '[data-modal-remaining]'
                );


            const labelElement =
                document.querySelector(
                    '[data-time-label]'
                );


            if (
                !remainingElement ||
                !labelElement
            ) {

                return;
            }


            let seconds;


            if (
                card.dataset.status === 'cancelled'
            ) {
                seconds = 0;
                labelElement.textContent = 'Cancelled';

            } else if (
                card.dataset.status === 'in_progress'
            ) {

                seconds =
                    (
                        end.getTime() -
                        now.getTime()
                    ) / 1000;

                labelElement.textContent =
                    'Time Remaining';

            } else if (
                card.dataset.status === 'finished'
            ) {

                seconds = 0;
                labelElement.textContent =
                    'Finished';

            } else {

                seconds =
                    (
                        start.getTime() -
                        now.getTime()
                    ) / 1000;

                labelElement.textContent =
                    'Starts In';
            }


            remainingElement.textContent =
                formatRemaining(
                    seconds
                );
        }


        /* ============================================================
           ESCAPE HTML
        ============================================================ */

        function escapeHtml(value) {

            return String(
                    value ?? ''
                )
                .replace(
                    /&/g,
                    '&amp;'
                )
                .replace(
                    /</g,
                    '&lt;'
                )
                .replace(
                    />/g,
                    '&gt;'
                )
                .replace(
                    /"/g,
                    '&quot;'
                )
                .replace(
                    /'/g,
                    '&#039;'
                );
        }


        /* ============================================================
           LOAD ABSENT TRAINEES
        ============================================================ */

        function loadAbsentTrainees(card) {

            const scheduleId =
                card.dataset.scheduleId;


            const listElement =
                document.querySelector(
                    '[data-modal-attendance-list]'
                );


            const countElement =
                document.querySelector(
                    '[data-modal-attendance-count]'
                );


            if (
                !scheduleId ||
                !listElement
            ) {

                return;
            }


            const students = attendanceBySchedule[scheduleId] || [];

            if (countElement) {
                countElement.textContent = students.length;
            }

            if (!students.length) {
                listElement.innerHTML = `
                    <div class="attendance-empty">
                        <i class="fas fa-check-circle"></i>
                        No absent trainees.
                    </div>
                `;
                return;
            }

            listElement.innerHTML = students.map(function(student) {
                return `
                    <div class="attendance-student">
                        <div class="student-info">
                            <div class="student-name">
                                ${escapeHtml(student.trainee_name || '-')}
                            </div>
                            <div class="student-meta">
                                <span class="student-meta-item">
                                    <i class="fas fa-id-card"></i>
                                    ${escapeHtml(student.academic_number || '-')}
                                </span>
                                <span class="student-meta-item">
                                    <i class="fas fa-layer-group"></i>
                                    ${escapeHtml(student.section_code || '-')}
                                </span>
                            </div>
                        </div>
                        <span class="student-status">Absent</span>
                    </div>
                `;
            }).join('');
        }



        async function openLectureModal(card) {

            const scheduleId =
                card.dataset.scheduleId;

            let refreshedCard = null;

            try {
                const response = await fetch(
                    '/lectures/data', {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        cache: 'no-store'
                    }
                );

                if (!response.ok) {
                    throw new Error('Failed to load fresh lecture details.');
                }

                renderDashboardItems(await response.json());

                refreshedCard = Array.from(
                    document.querySelectorAll('[data-lecture-card]')
                ).find(function(currentCard) {
                    return currentCard.dataset.scheduleId === scheduleId;
                });
            } catch (error) {
                console.error('Lecture details refresh error:', error);
            }

            const latestCard = refreshedCard || card;
            lastFocusedLecture = latestCard;
            populateLectureModal(latestCard);
        }


        function populateLectureModal(card, focusCloseButton = true) {

            selectedLecture =
                card;


            const start =
                parseDateTime(
                    card.dataset.start
                );


            const end =
                parseDateTime(
                    card.dataset.end
                );


            if (
                !start ||
                !end
            ) {

                return;
            }


            lastFocusedLecture = card;


            const now =
                new Date();


            const visualState =
                getVisualState(
                    card.dataset.status,
                    start,
                    end,
                    now
                );



            const modalHeader =
                document.querySelector(
                    '[data-modal-header]'
                );


            modalHeader.classList.remove(
                'not-started',
                'waiting',
                'in-progress',
                'finished',
                'cancelled'
            );


            if (
                card.dataset.status === 'cancelled'
            ) {

                modalHeader.classList.add(
                    'cancelled'
                );

            } else if (
                card.dataset.status === 'in_progress'
            ) {

                modalHeader.classList.add(
                    'in-progress'
                );

            } else if (
                card.dataset.status === 'finished'
            ) {

                modalHeader.classList.add(
                    'finished'
                );

            } else {

                modalHeader.classList.add(
                    'not-started'
                );
            }



            document.querySelector(
                    '[data-modal-batch]'
                ).textContent =
                card.dataset.batchCode || '-';


            document.querySelector(
                    '[data-modal-trainer]'
                ).textContent =
                card.dataset.trainer || '-';


            document.querySelector(
                    '[data-modal-course]'
                ).textContent =
                card.dataset.courseCode || '-';



            const statusElement =
                document.querySelector(
                    '[data-modal-status]'
                );


            if (
                card.dataset.status === 'cancelled'
            ) {

                statusElement.textContent =
                    'Cancelled';

            } else if (
                card.dataset.status === 'in_progress'
            ) {

                statusElement.textContent =
                    'In Progress';

            } else if (
                card.dataset.status === 'finished'
            ) {

                statusElement.textContent =
                    'Finished';

            } else {

                statusElement.textContent =
                    'Not Started';
            }



            document.querySelector(
                    '[data-modal-time]'
                ).textContent =

                start.toLocaleTimeString(
                    [], {
                        hour: '2-digit',
                        minute: '2-digit'
                    }
                )

                +

                ' - '

                +

                end.toLocaleTimeString(
                    [], {
                        hour: '2-digit',
                        minute: '2-digit'
                    }
                );



            const delivery =
                (
                    card.dataset.delivery || ''
                ).toLowerCase();


            const roomElement =
                document.querySelector(
                    '[data-modal-room]'
                );


            const onlineRow =
                document.querySelector(
                    '[data-online-row]'
                );


            const onlineLinkElement =
                document.querySelector(
                    '[data-modal-online-link]'
                );


            if (
                delivery === 'online'
            ) {

                roomElement.textContent =
                    'Online';


                if (onlineRow) {

                    onlineRow.style.display =
                        'flex';
                }


                if (onlineLinkElement) {

                    onlineLinkElement.textContent =
                        card.dataset.onlineLink ||
                        'No online link';
                }

            } else {

                roomElement.textContent =
                    card.dataset.room ||
                    'No Room';


                if (onlineRow) {

                    onlineRow.style.display =
                        'none';
                }
            }


            document.querySelector(
                    '[data-modal-delivery]'
                ).textContent =
                card.dataset.delivery || '-';


            document.querySelector(
                    '[data-modal-trainer-2]'
                ).textContent =
                card.dataset.trainer || '-';


            document.querySelector(
                    '[data-modal-course-full]'
                ).textContent =
                card.dataset.course || '-';


            document.querySelector(
                    '[data-modal-batch-full]'
                ).textContent =
                card.dataset.batch || '-';


            document.querySelector(
                    '[data-modal-section]'
                ).textContent =
                card.dataset.section || '-';



            document.querySelector(
                    '[data-modal-trainees]'
                ).textContent =
                card.dataset.trainees || '0';


            document.querySelector(
                    '[data-modal-present]'
                ).textContent =
                card.dataset.present || '0';


            document.querySelector(
                    '[data-modal-absent]'
                ).textContent =
                card.dataset.absent || '0';


            document.querySelector(
                    '[data-modal-late]'
                ).textContent =
                card.dataset.late || '0';


            document.querySelector(
                    '[data-modal-excused]'
                ).textContent =
                card.dataset.excused || '0';



            updateAttendancePercentage(
                card
            );



            loadAbsentTrainees(
                card
            );



            const durationMinutes =
                Math.floor(
                    (
                        end.getTime() -
                        start.getTime()
                    ) / 60000
                );


            const hours =
                Math.floor(
                    durationMinutes / 60
                );


            const minutes =
                durationMinutes % 60;


            let durationText =
                '';


            if (
                hours > 0
            ) {

                durationText +=

                    hours +

                    (
                        hours === 1 ?
                        ' hour' :
                        ' hours'
                    );
            }


            if (
                minutes > 0
            ) {

                if (
                    durationText
                ) {

                    durationText +=
                        ' ';
                }


                durationText +=

                    minutes +

                    ' min';
            }


            if (
                !durationText
            ) {

                durationText =
                    '0 min';
            }


            document.querySelector(
                    '[data-modal-duration]'
                ).textContent =
                durationText;



            updateModalTime(
                card
            );



            lectureModal.classList.add(
                'active'
            );
            lectureModal.setAttribute(
                'aria-hidden',
                'false'
            );


            document.body.style.overflow =
                'hidden';


            if (focusCloseButton && closeLectureModal) {
                closeLectureModal.focus();
            }
        }



        function updateAttendancePercentage(card) {

            const trainees =
                parseInt(
                    card.dataset.trainees || 0
                );


            const present =
                parseInt(
                    card.dataset.present || 0
                );


            let percentage =
                0;


            if (
                trainees > 0
            ) {

                percentage =
                    (
                        present /
                        trainees
                    ) * 100;
            }


            percentage =
                Math.min(
                    100,
                    Math.max(
                        0,
                        percentage
                    )
                );


            percentage =
                Math.round(
                    percentage * 10
                ) / 10;


            const percentageElement =
                document.querySelector(
                    '[data-modal-attendance-percentage]'
                );


            const progressElement =
                document.querySelector(
                    '[data-modal-attendance-progress]'
                );


            if (
                percentageElement
            ) {

                percentageElement.textContent =
                    percentage + '%';
            }


            if (
                progressElement
            ) {

                progressElement.style.width =
                    percentage + '%';
            }
        }



        function attachLectureCardEvents() {

            document
                .querySelectorAll(
                    '[data-lecture-card]'
                )
                .forEach(
                    function(card) {


                        if (
                            card.dataset.eventsAttached === 'true'
                        ) {

                            return;
                        }


                        card.dataset.eventsAttached =
                            'true';


                        card.addEventListener(
                            'click',
                            function(event) {

                                if (
                                    event.target.closest(
                                        '[data-start-button]'
                                    )
                                ) {

                                    return;
                                }


                                openLectureModal(
                                    card
                                );

                            }
                        );


                        card.addEventListener(
                            'keydown',
                            function(event) {

                                if (
                                    event.key === 'Enter' ||
                                    event.key === ' '
                                ) {
                                    event.preventDefault();
                                    openLectureModal(card);
                                }
                            }
                        );

                    }
                );
        }



        function closeModal() {

            lectureModal.classList.remove(
                'active'
            );
            lectureModal.setAttribute(
                'aria-hidden',
                'true'
            );


            selectedLecture =
                null;


            document.body.style.overflow =
                '';


            if (
                lastFocusedLecture &&
                document.body.contains(lastFocusedLecture)
            ) {
                lastFocusedLecture.focus();
            }

            lastFocusedLecture = null;
        }


        if (
            closeLectureModal
        ) {

            closeLectureModal.addEventListener(
                'click',
                closeModal
            );
        }


        lectureModal.addEventListener(
            'click',
            function(event) {

                if (
                    event.target ===
                    lectureModal
                ) {

                    closeModal();
                }

            }
        );


        document.addEventListener(
            'keydown',
            function(event) {

                if (
                    event.key ===
                    'Escape'
                ) {

                    closeModal();
                }

            }
        );




        attachLectureCardEvents();

        updateLectures();




        setInterval(
            updateLectures,
            1000
        );
    </script>
    <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
    <script>
        const pusher =
            new Pusher(
                '{{ config('broadcasting.connections.pusher.key') }}', {
                    cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',

                    forceTLS: true
                }
            );




        const lectureChannel =
            pusher.subscribe(
                'lectures'
            );


        lectureChannel.bind(
            'lectures.updated',
            function(data) {

                console.log(
                    'Lectures updated:',
                    data
                );

                refreshLectures();
            }
        );

        pusher.connection.bind(
            'connected',
            function() {

                console.log(
                    'Pusher connected'
                );

            }
        );

        pusher.connection.bind(
            'error',
            function(error) {

                console.error(
                    'Pusher connection error:',
                    error
                );

            }
        );
    </script>


</body>

</html>
