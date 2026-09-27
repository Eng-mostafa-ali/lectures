<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Today's Lectures & Rooms</title>


    {{-- =========================================================
        FONT AWESOME
    ========================================================== --}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


    <style>
        /* =========================================================
           RESET
        ========================================================== */

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
        }

        body {
            background: #f4f6f9;
            color: #172b4d;

            font-family:
                Arial,
                Helvetica,
                sans-serif;
        }


        /* =========================================================
           PAGE
        ========================================================== */

        .dashboard-wrapper {

            width: 100%;

            padding:
                28px 30px 50px;
        }


        /* =========================================================
           HEADER
        ========================================================== */

        .dashboard-header {

            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-bottom: 30px;
        }

        .dashboard-title {

            margin: 0;

            font-size: 24px;

            font-weight: 800;

            color: #172b4d;
        }

        .dashboard-date {

            margin-top: 6px;

            font-size: 12px;

            color: #7a869a;

            font-weight: 600;
        }

        .total-badge {

            padding:
                10px 15px;

            background: #ffffff;

            border:
                1px solid #e4e7ec;

            border-radius: 8px;

            font-size: 11px;

            font-weight: 700;

            color: #5e6c84;
        }


        /* =========================================================
           SECTION HEADER
        ========================================================== */

        .section-header {

            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-top: 28px;

            margin-bottom: 14px;
        }

        .section-title {

            display: flex;

            align-items: center;

            gap: 9px;

            font-size: 15px;

            font-weight: 800;

            color: #172b4d;
        }

        .section-title i {

            font-size: 16px;
        }

        .section-count {

            padding:
                7px 11px;

            background: #ffffff;

            border:
                1px solid #e4e7ec;

            border-radius: 7px;

            font-size: 10px;

            font-weight: 700;

            color: #5e6c84;
        }


        /* =========================================================
           LECTURES GRID
        ========================================================== */

        .lectures-grid {

            display: grid;

            grid-template-columns:
                repeat(auto-fill,
                    minmax(330px, 1fr));

            gap: 18px;
        }


        /* =========================================================
           LECTURE CARD
        ========================================================== */

        .lecture-card {

            position: relative;

            min-height: 250px;

            padding: 18px;

            border-radius: 10px;

            cursor: pointer;

            overflow: hidden;

            border:
                1px solid rgba(0, 0, 0, .08);

            box-shadow:
                0 4px 12px rgba(0, 0, 0, .06);

            transition:
                transform .2s ease,
                box-shadow .2s ease,
                background .25s ease;
        }

        .lecture-card:hover {

            transform:
                translateY(-3px);

            box-shadow:
                0 10px 25px rgba(0, 0, 0, .13);
        }


        /* =========================================================
           BLACK / GRAY
           BEFORE START
        ========================================================== */

        .lecture-not-started {

            background:
                rgba(153, 153, 153, 0.9);

            color:
                #344054;
        }

        .lecture-not-started .muted {

            color:
                #5f6b7a;
        }

        .lecture-cancelled {
            background: #dc3545;
            color: #ffffff;
        }

        .lecture-cancelled .muted {
            color: #ffdadd;
        }


        /* =========================================================
           RED
           TIME ARRIVED BUT TEACHER DID NOT START
        ========================================================== */

        .lecture-waiting {

            background:
                #dc3545;

            color:
                #ffffff;
        }

        .lecture-waiting .muted {

            color:
                #ffdadd;
        }


        /* =========================================================
           WHITE
           IN PROGRESS
        ========================================================== */

        .lecture-in-progress {

            background:
                #ffffff;

            color:
                #172b4d;

            border-color:
                #dfe3e8;
        }

        .lecture-in-progress .muted {

            color:
                #7a869a;
        }


        /* =========================================================
           CARD TOP
        ========================================================== */

        .lecture-top {

            display: flex;

            align-items: flex-start;

            justify-content: space-between;

            gap: 15px;
        }

        .lecture-main {

            display: flex;

            align-items: center;

            min-width: 0;
        }


        /* =========================================================
           ICON
        ========================================================== */

        .lecture-icon {

            width: 46px;

            height: 46px;

            min-width: 46px;

            display: flex;

            align-items: center;

            justify-content: center;

            margin-right: 11px;

            border-radius: 8px;

            background:
                #ffffff;
        }

        .lecture-icon i {

            font-size:
                21px;

            color:
                #3699ff;
        }

        .lecture-not-started .lecture-icon i {

            color:
                #000000;
        }

        .lecture-waiting .lecture-icon i {

            color:
                #dc3545;
        }

        .lecture-in-progress .lecture-icon i {

            color:
                #3699ff;
        }


        /* =========================================================
           TEXT
        ========================================================== */

        .lecture-info {

            min-width: 0;
        }

        .batch-code {

            font-size:
                14px;

            font-weight:
                800;

            white-space:
                nowrap;

            overflow:
                hidden;

            text-overflow:
                ellipsis;
        }

        .trainer-name {

            margin-top:
                5px;

            font-size:
                10px;

            font-weight:
                600;

            white-space:
                nowrap;

            overflow:
                hidden;

            text-overflow:
                ellipsis;
        }

        .course-code {

            font-size:
                10px;

            font-weight:
                700;

            white-space:
                nowrap;
        }


        /* =========================================================
           TIME
        ========================================================== */

        .lecture-times {

            display:
                grid;

            grid-template-columns:
                1fr 1fr;

            gap:
                10px;

            margin-top:
                15px;
        }

        .time-item {

            display:
                flex;

            align-items:
                center;

            gap:
                6px;

            padding:
                8px 9px;

            border-radius:
                6px;

            font-size:
                10px;

            font-weight:
                700;
        }

        .lecture-not-started .time-item {

            background:
                rgba(255, 255, 255, .10);
        }

        .lecture-waiting .time-item {

            background:
                rgba(0, 0, 0, .12);
        }

        .lecture-in-progress .time-item {

            background:
                #eef2f7;
        }


        /* =========================================================
           PROGRESS
        ========================================================== */

        .progress-container {

            display:
                flex;

            align-items:
                center;

            gap:
                10px;

            margin-top:
                16px;
        }

        .progress-track {

            flex:
                1;

            height:
                5px;

            overflow:
                hidden;

            border-radius:
                10px;

            background:
                rgba(127, 127, 127, .25);
        }

        .progress-bar {

            width:
                0%;

            height:
                100%;

            border-radius:
                10px;

            background:
                #ffffff;

            transition:
                width .5s linear;
        }

        .lecture-in-progress .progress-bar {

            background:
                #3699ff;
        }

        .remaining-time {

            min-width:
                65px;

            text-align:
                right;

            font-size:
                9px;

            font-weight:
                800;
        }


        /* =========================================================
           FOOTER
        ========================================================== */

        .lecture-footer {

            display:
                flex;

            align-items:
                center;

            gap:
                18px;

            margin-top:
                15px;

            padding-top:
                11px;

            border-top:
                1px solid rgba(127, 127, 127, .25);
        }

        .footer-item {

            display:
                flex;

            align-items:
                center;

            gap:
                5px;

            font-size:
                9px;

            font-weight:
                700;
        }


        /* =========================================================
           AVAILABLE ROOMS
        ========================================================== */

        .rooms-grid {

            display:
                grid;

            grid-template-columns:
                repeat(auto-fill,
                    minmax(220px, 1fr));

            gap:
                16px;
        }

        .room-card {

            min-height:
                150px;

            padding:
                16px;

            background:
                #ffffff;

            border:
                1px dashed #1bc5bd;

            border-radius:
                10px;

            transition:
                .2s ease;
        }

        .room-card:hover {

            transform:
                translateY(-2px);

            box-shadow:
                0 6px 15px rgba(27, 197, 189, .10);
        }

        .room-header {

            display:
                flex;

            align-items:
                center;
        }

        .room-icon {

            width:
                42px;

            height:
                42px;

            min-width:
                42px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            margin-right:
                10px;

            background:
                #1bc5bd;

            border-radius:
                7px;
        }

        .room-icon i {

            color:
                #ffffff;

            font-size:
                19px;
        }

        .room-code {

            font-size:
                13px;

            font-weight:
                800;

            color:
                #172b4d;
        }

        .room-status {

            margin-top:
                3px;

            color:
                #1bc5bd;

            font-size:
                10px;

            font-weight:
                700;
        }

        .room-free {

            margin-top:
                18px;

            font-size:
                10px;

            font-weight:
                700;

            color:
                #172b4d;
        }

        .room-footer {

            margin-top:
                15px;

            padding-top:
                10px;

            border-top:
                1px solid #e4e7ec;

            font-size:
                9px;

            color:
                #7a869a;
        }


        /* =========================================================
           MODAL
        ========================================================== */

        .lecture-modal {

            position:
                fixed;

            inset:
                0;

            z-index:
                9999;

            display:
                none;

            align-items:
                center;

            justify-content:
                flex-end;

            background:
                rgba(10, 20, 30, .50);

            backdrop-filter:
                blur(3px);
        }

        .lecture-modal.active {

            display:
                flex;
        }

        .modal-panel {

            width:
                470px;

            max-width:
                94vw;

            height:
                100vh;

            overflow-y:
                auto;

            background:
                #ffffff;

            box-shadow:
                -8px 0 30px rgba(0, 0, 0, .15);

            animation:
                slideIn .25s ease;
        }

        @keyframes slideIn {

            from {

                transform:
                    translateX(100%);
            }

            to {

                transform:
                    translateX(0);
            }
        }


        /* =========================================================
           MODAL HEADER
        ========================================================== */

        .modal-header {

            padding:
                22px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            color:
                #ffffff;
        }

        .modal-header.not-started {

            background:
                #000000;
        }

        .modal-header.waiting {

            background:
                #dc3545;
        }

        .modal-header.in-progress {

            background:
                #ffffff;

            color:
                #172b4d;

            border-bottom:
                1px solid #e4e7ec;
        }

        .modal-header-left {

            display:
                flex;

            align-items:
                center;
        }

        .modal-icon {

            width:
                48px;

            height:
                48px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            margin-right:
                12px;

            border-radius:
                8px;

            background:
                #ffffff;
        }

        .modal-icon i {

            color:
                #3699ff;

            font-size:
                21px;
        }

        .modal-title {

            margin:
                0;

            font-size:
                18px;

            font-weight:
                800;
        }

        .modal-trainer {

            margin-top:
                4px;

            font-size:
                11px;

            opacity:
                .8;
        }

        .modal-course {

            font-size:
                11px;

            font-weight:
                700;
        }

        .modal-close {

            border:
                0;

            background:
                transparent;

            color:
                inherit;

            font-size:
                20px;

            cursor:
                pointer;
        }


        /* =========================================================
           MODAL BODY
        ========================================================== */

        .modal-body {

            padding:
                22px;
        }

        .modal-status-row {

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap:
                10px;

            margin-bottom:
                22px;
        }

        .modal-status {

            display:
                inline-block;

            padding:
                7px 12px;

            border-radius:
                6px;

            background:
                #f0f2f5;

            color:
                #172b4d;

            font-size:
                10px;

            font-weight:
                800;
        }

        .modal-time {

            font-size:
                11px;

            font-weight:
                700;

            color:
                #5e6c84;
        }


        /* =========================================================
           DETAILS
        ========================================================== */

        .details-grid {

            display:
                grid;

            grid-template-columns:
                repeat(3, 1fr);

            padding-bottom:
                20px;

            margin-bottom:
                20px;

            border-bottom:
                1px solid #e4e7ec;
        }

        .detail-box {

            padding:
                0 12px;

            border-right:
                1px solid #e4e7ec;
        }

        .detail-box:first-child {

            padding-left:
                0;
        }

        .detail-box:last-child {

            padding-right:
                0;

            border-right:
                0;
        }

        .detail-label {

            display:
                block;

            margin-bottom:
                6px;

            font-size:
                10px;

            color:
                #7a869a;
        }

        .detail-value {

            font-size:
                11px;

            font-weight:
                700;

            color:
                #172b4d;

            word-break:
                break-word;
        }


        /* =========================================================
           INFO ROW
        ========================================================== */

        .info-row {

            display:
                flex;

            align-items:
                flex-start;

            gap:
                12px;

            padding:
                14px 0;

            border-bottom:
                1px solid #eef0f3;
        }

        .info-icon {

            width:
                32px;

            height:
                32px;

            min-width:
                32px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            color:
                #5e6c84;

            background:
                #f4f6f9;

            border-radius:
                6px;
        }

        .info-label {

            font-size:
                10px;

            color:
                #7a869a;

            margin-bottom:
                3px;
        }

        .info-value {

            font-size:
                11px;

            font-weight:
                700;

            color:
                #172b4d;

            word-break:
                break-word;
        }


        /* =========================================================
           ATTENDANCE
        ========================================================== */

        .attendance-details {

            display:
                grid;

            grid-template-columns:
                repeat(5, 1fr);

            gap:
                7px;

            margin-top:
                20px;

            padding-bottom:
                20px;

            border-bottom:
                1px solid #e4e7ec;
        }

        .attendance-box {

            text-align:
                center;

            padding:
                10px 4px;

            border-radius:
                7px;

            background:
                #f7f9fc;
        }

        .attendance-number {

            display:
                block;

            font-size:
                15px;

            font-weight:
                800;

            color:
                #172b4d;
        }

        .attendance-label {

            display:
                block;

            margin-top:
                3px;

            font-size:
                8px;

            color:
                #7a869a;
        }


        /* =========================================================
           ATTENDANCE PERCENTAGE
        ========================================================== */

        .attendance-percentage {

            margin-top:
                20px;

            padding:
                16px;

            border-radius:
                8px;

            background:
                #eef7ff;

            border:
                1px solid #cfe7ff;
        }

        .attendance-percentage-top {

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            margin-bottom:
                9px;
        }

        .attendance-percentage-label {

            font-size:
                10px;

            font-weight:
                700;

            color:
                #5e6c84;
        }

        .attendance-percentage-value {

            font-size:
                20px;

            font-weight:
                800;

            color:
                #3699ff;
        }

        .attendance-progress {

            width:
                100%;

            height:
                7px;

            overflow:
                hidden;

            border-radius:
                10px;

            background:
                #dceeff;
        }

        .attendance-progress-value {

            width:
                0%;

            height:
                100%;

            border-radius:
                10px;

            background:
                #3699ff;

            transition:
                width .4s ease;
        }


        /* =========================================================
           ABSENT TRAINEES
        ========================================================== */

        .attendance-students {

            margin-top:
                20px;

            padding:
                16px;

            border:
                1px solid #e4e7ec;

            border-radius:
                8px;

            background:
                #ffffff;
        }

        .attendance-students-header {

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            margin-bottom:
                12px;
        }

        .attendance-students-title {

            display:
                flex;

            align-items:
                center;

            gap:
                7px;

            font-size:
                11px;

            font-weight:
                800;

            color:
                #172b4d;
        }

        .attendance-students-title i {

            color:
                #dc3545;
        }

        .attendance-students-count {

            min-width:
                25px;

            height:
                25px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            padding:
                0 7px;

            border-radius:
                50%;

            background:
                #fff2f3;

            color:
                #dc3545;

            font-size:
                10px;

            font-weight:
                800;
        }


        /* =========================================================
           STUDENT LIST
        ========================================================== */

        .attendance-students-list {

            display:
                flex;

            flex-direction:
                column;

            gap:
                8px;

            max-height:
                320px;

            overflow-y:
                auto;
        }

        .attendance-student {

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap:
                12px;

            padding:
                11px 10px;

            background:
                #f8f9fb;

            border:
                1px solid #eef0f3;

            border-radius:
                7px;
        }

        .student-info {

            min-width:
                0;

            flex:
                1;
        }

        .student-name {

            font-size:
                11px;

            font-weight:
                800;

            color:
                #172b4d;

            white-space:
                nowrap;

            overflow:
                hidden;

            text-overflow:
                ellipsis;
        }

        .student-meta {

            display:
                flex;

            align-items:
                center;

            flex-wrap:
                wrap;

            gap:
                10px;

            margin-top:
                5px;
        }

        .student-meta-item {

            display:
                inline-flex;

            align-items:
                center;

            gap:
                4px;

            font-size:
                8px;

            color:
                #7a869a;

            font-weight:
                600;
        }

        .student-meta-item i {

            font-size:
                8px;
        }

        .student-status {

            flex-shrink:
                0;

            padding:
                5px 8px;

            border-radius:
                5px;

            background:
                #fff2f3;

            color:
                #dc3545;

            font-size:
                8px;

            font-weight:
                800;
        }


        /* =========================================================
           ATTENDANCE LOADING
        ========================================================== */

        .attendance-loading {

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            gap:
                8px;

            padding:
                25px 10px;

            color:
                #7a869a;

            font-size:
                10px;

            font-weight:
                600;
        }


        /* =========================================================
           ATTENDANCE EMPTY
        ========================================================== */

        .attendance-empty {

            padding:
                20px 10px;

            text-align:
                center;

            color:
                #7a869a;

            font-size:
                10px;

            font-weight:
                600;
        }

        .attendance-empty i {

            display:
                block;

            margin-bottom:
                7px;

            font-size:
                20px;

            color:
                #1bc5bd;
        }


        /* =========================================================
           TIME SUMMARY
        ========================================================== */

        .time-summary {

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            margin-top:
                20px;

            padding:
                16px;

            border-radius:
                8px;

            background:
                #fff2f3;

            border:
                1px solid #ffd5d9;
        }

        .time-summary-left {

            display:
                flex;

            align-items:
                center;

            gap:
                10px;
        }

        .time-summary-icon {

            color:
                #dc3545;

            font-size:
                20px;
        }

        .time-summary-label {

            font-size:
                10px;

            color:
                #dc3545;

            font-weight:
                700;
        }

        .time-summary-value {

            margin-top:
                2px;

            font-size:
                21px;

            font-weight:
                800;

            color:
                #dc3545;
        }

        .duration {

            text-align:
                right;
        }

        .duration-label {

            font-size:
                9px;

            color:
                #7a869a;
        }

        .duration-value {

            margin-top:
                3px;

            font-size:
                12px;

            font-weight:
                800;

            color:
                #172b4d;
        }


        /* =========================================================
           EMPTY
        ========================================================== */

        .empty-card {

            padding:
                30px;

            background:
                #ffffff;

            border:
                1px solid #e4e7ec;

            border-radius:
                10px;

            text-align:
                center;

            color:
                #7a869a;

            font-size:
                12px;
        }


        /* =========================================================
           RESPONSIVE
        ========================================================== */

        @media (max-width: 900px) {

            .lectures-grid {

                grid-template-columns:
                    repeat(2, 1fr);
            }

            .rooms-grid {

                grid-template-columns:
                    repeat(3, 1fr);
            }
        }

        @media (max-width: 650px) {

            .dashboard-wrapper {

                padding:
                    18px 15px 30px;
            }

            .dashboard-header {

                align-items:
                    flex-start;

                flex-direction:
                    column;

                gap:
                    15px;
            }

            .lectures-grid,
            .rooms-grid {

                grid-template-columns:
                    1fr;
            }

            .modal-panel {

                width:
                    100%;

                max-width:
                    100%;
            }

            .details-grid {

                grid-template-columns:
                    1fr;

                gap:
                    12px;
            }

            .detail-box {

                padding:
                    0;

                border-right:
                    0;
            }

            .attendance-details {

                grid-template-columns:
                    repeat(3, 1fr);
            }

            .attendance-student {

                align-items:
                    flex-start;

                flex-direction:
                    column;
            }

            .student-status {

                align-self:

                    flex-start;
            }
        }
    </style>

    <style>
        /* =========================================================
           DASHBOARD REFINEMENT
        ========================================================== */

        :root {
            --page-bg: #f4f6f9;
            --top-accent: #263c3f;
            --surface: #ffffff;
            --ink: #102f5e;
            --ink-soft: #344054;
            --muted: #5e6c84;
            --muted-soft: #5e6c84;
            --teal-ink: #006b66;
            --line: #e1e6ee;
            --line-soft: #eef1f5;
            --blue: #3699ff;
            --blue-soft: #eef7ff;
            --blue-line: #cfe7ff;
            --teal: #1bc5bd;
            --teal-soft: #e8fbfa;
            --danger: #dc3545;
            --danger-soft: #fff2f3;
            --not-started-bg: #a6a6a6;
            --shadow-card: 0 10px 24px rgba(16, 47, 94, .08);
            --shadow-card-hover: 0 14px 30px rgba(16, 47, 94, .14);
            --radius-card: 10px;
            --radius-control: 8px;
        }

        body {
            background: var(--page-bg);
            color: var(--ink);
            border-top: 10px solid var(--top-accent);
        }

        .dashboard-wrapper {
            padding: 28px 30px 50px;
        }

        .dashboard-header {
            align-items: flex-start;
            margin-bottom: 34px;
        }

        .dashboard-title {
            color: var(--ink);
            font-size: 28px;
            line-height: 1.15;
            letter-spacing: -.02em;
        }

        .dashboard-date {
            color: var(--muted-soft);
            font-size: 12px;
            letter-spacing: .01em;
        }

        .total-badge,
        .section-count {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius-control);
            color: var(--muted);
        }

        .total-badge {
            padding: 10px 14px;
            font-size: 11px;
        }

        .total-badge i {
            color: var(--ink);
            margin-right: 4px;
        }

        .section-header {
            margin-top: 28px;
            margin-bottom: 14px;
        }

        .dashboard-header+.section-header {
            margin-top: 0;
        }

        .section-title {
            color: var(--ink);
            font-size: 15px;
            letter-spacing: -.01em;
        }

        .section-count {
            padding: 7px 11px;
            font-size: 10px;
        }

        .lectures-grid {
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            align-items: start;
            max-width: none;
            gap: 18px;
        }

        @media (max-width: 1600px) {
            .lectures-grid {
                grid-template-columns: repeat(5, minmax(0, 1fr));
            }
        }

        @media (max-width: 1200px) {
            .lectures-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
        }

        @media (max-width: 900px) {
            .lectures-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        .rooms-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
        }

        .lecture-card {
            min-height: 0;
            padding: 20px;
            border: 1px solid var(--line);
            border-radius: var(--radius-card);
            background: var(--surface);
            color: var(--ink);
            box-shadow: var(--shadow-card);
            transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
        }

        .lecture-card:hover {
            transform: translateY(-2px);
            border-color: var(--blue-line);
            box-shadow: var(--shadow-card-hover);
        }

        .lecture-card:focus-visible {
            outline: 3px solid rgba(54, 153, 255, .35);
            outline-offset: 3px;
        }

        .lecture-not-started {
            background: var(--not-started-bg);
            border-color: rgba(0, 0, 0, .12);
            box-shadow: 0 8px 18px rgba(0, 0, 0, .08);
            color: var(--ink);
        }

        .lecture-not-started .course-code,
        .lecture-not-started .detail-item,
        .lecture-not-started .lecture-footer>div {
            color: var(--ink);
            opacity: 1;
        }

        .lecture-waiting {
            background: var(--danger);
            border-color: var(--danger);
            color: var(--surface);
        }

        .lecture-cancelled {
            background: var(--danger);
            border-color: var(--danger);
            color: var(--surface);
        }

        .lecture-cancelled .course-code,
        .lecture-cancelled .detail-item,
        .lecture-cancelled .lecture-footer>div {
            color: var(--surface);
            opacity: 1;
        }

        .lecture-in-progress,
        .lecture-finished {
            background: var(--surface);
            border-color: var(--line);
            color: var(--ink);
        }

        .lecture-top {
            gap: 16px;
        }

        .lecture-main {
            flex: 1;
            align-items: flex-start;
        }

        .lecture-icon {
            width: 46px;
            height: 46px;
            min-width: 46px;
            margin-right: 12px;
            border-radius: var(--radius-control);
            background: var(--surface);
            box-shadow: 0 2px 5px rgba(16, 47, 94, .08);
        }

        .lecture-icon i {
            color: var(--blue);
        }

        .lecture-not-started .lecture-icon i {
            color: #000000;
        }

        .lecture-waiting .lecture-icon i {
            color: var(--danger);
        }

        .lecture-info {
            flex: 1;
        }

        .batch-code {
            color: inherit;
            font-size: 13px;
            line-height: 1.2;
        }

        .course-name {
            margin-top: 3px;
            color: inherit;
            font-size: 16px;
            font-weight: 500;
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .course-code {
            margin-top: 3px;
            color: inherit;
            font-size: 10px;
            opacity: .82;
        }

        .lecture-status {
            flex: 0 0 auto;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            min-height: 26px;
            padding: 4px 9px;
            border: 1px solid var(--line);
            border-radius: 999px;
            background: var(--surface);
            color: var(--ink-soft);
            font-size: 10px;
            font-weight: 800;
            line-height: 1;
            white-space: nowrap;
        }

        .lecture-not-started .status-badge {
            background: rgba(255, 255, 255, .72);
            border-color: rgba(0, 0, 0, .08);
            color: var(--ink-soft);
        }

        .lecture-cancelled .status-badge {
            background: rgba(255, 255, 255, .16);
            border-color: rgba(255, 255, 255, .32);
            color: var(--surface);
        }

        .lecture-waiting .status-badge {
            background: rgba(255, 255, 255, .16);
            border-color: rgba(255, 255, 255, .32);
            color: var(--surface);
        }

        .lecture-in-progress .status-badge {
            border-color: var(--blue-line);
            background: var(--blue-soft);
            color: #1769aa;
        }

        .lecture-time {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            gap: 9px;
            margin-top: 18px;
            padding: 10px 12px;
            border-radius: var(--radius-control);
            background: var(--blue-soft);
            color: var(--ink);
            font-size: 12px;
            font-weight: 800;
        }

        .lecture-not-started .lecture-time {
            background: rgba(255, 255, 255, .18);
        }

        .lecture-waiting .lecture-time {
            background: rgba(0, 0, 0, .12);
            color: var(--surface);
        }

        .time-block {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            min-width: 0;
        }

        .time-block:last-child {
            justify-content: flex-end;
        }

        .time-separator {
            color: var(--muted-soft);
            font-weight: 400;
        }

        .lecture-waiting .time-separator {
            color: rgba(255, 255, 255, .7);
        }

        .lecture-details {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 8px;
            margin-top: 15px;
        }

        .detail-item {
            display: flex;
            align-items: center;
            min-width: 0;
            gap: 7px;
            color: inherit;
            font-size: 11px;
            font-weight: 700;
            line-height: 1.25;
        }

        .detail-item span {
            min-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .detail-item i {
            flex: 0 0 14px;
            color: var(--muted);
            text-align: center;
        }

        .lecture-not-started .detail-item i {
            color: var(--ink-soft);
        }

        .lecture-waiting .detail-item i {
            color: rgba(255, 255, 255, .84);
        }

        .lecture-progress {
            margin-top: 17px;
        }

        .progress-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 7px;
            color: var(--muted);
            font-size: 10px;
            font-weight: 800;
        }

        .lecture-not-started .progress-header,
        .lecture-waiting .progress-header {
            color: inherit;
            opacity: 1;
        }

        .lecture-progress .attendance-percentage {
            margin: 0;
            padding: 0;
            border: 0;
            border-radius: 0;
            background: transparent;
            color: inherit;
            font-size: 11px;
            font-weight: 800;
        }

        .lecture-progress .progress-bar {
            width: 100%;
            height: 6px;
            overflow: hidden;
            border-radius: 999px;
            background: var(--line-soft);
        }

        .lecture-not-started .progress-bar {
            background: rgba(255, 255, 255, .28);
        }

        .lecture-waiting .progress-bar {
            background: rgba(0, 0, 0, .18);
        }

        .lecture-progress .progress-fill {
            width: 0;
            height: 100%;
            border-radius: inherit;
            background: var(--blue);
            transition: width .4s ease;
        }

        .lecture-not-started .progress-fill,
        .lecture-waiting .progress-fill {
            background: currentColor;
        }

        .lecture-attendance {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 6px;
            margin-top: 13px;
            padding-top: 12px;
            border-top: 1px solid var(--line-soft);
            color: var(--muted);
            font-size: 10px;
            font-weight: 700;
        }

        .lecture-attendance>div {
            display: flex;
            align-items: center;
            gap: 4px;
            min-width: 0;
        }

        .lecture-attendance i {
            flex: 0 0 auto;
        }

        .lecture-in-progress .lecture-attendance i {
            color: var(--blue);
        }

        .lecture-footer {
            gap: 18px;
            margin-top: 15px;
            padding-top: 11px;
            border-top: 1px solid var(--line);
        }

        .lecture-footer>div {
            display: inline-flex;
            align-items: center;
            min-width: 0;
            gap: 6px;
            color: inherit;
            font-size: 10px;
            font-weight: 700;
        }

        .lecture-footer i {
            color: var(--muted);
        }

        .lecture-waiting .lecture-footer {
            border-top-color: rgba(255, 255, 255, .28);
        }

        .lecture-waiting .lecture-footer i {
            color: rgba(255, 255, 255, .84);
        }

        .room-card {
            min-height: 150px;
            padding: 16px;
            border: 1px dashed var(--teal);
            border-radius: var(--radius-card);
            background: var(--surface);
            box-shadow: none;
        }

        .room-card:hover {
            transform: none;
            box-shadow: none;
        }

        .room-header {
            gap: 0;
        }

        .room-icon {
            width: 42px;
            height: 42px;
            min-width: 42px;
            margin-right: 10px;
            border-radius: 7px;
            background: var(--teal);
        }

        .room-code {
            color: var(--ink);
            font-size: 13px;
        }

        .room-status {
            color: var(--teal-ink);
            font-size: 10px;
        }

        .room-free {
            margin-top: 18px;
            color: var(--ink);
            font-size: 10px;
        }

        .room-footer {
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid var(--line);
            color: var(--muted);
            font-size: 9px;
        }

        .empty-card {
            min-height: 120px;
            display: grid;
            place-items: center;
            padding: 24px;
            border: 1px solid var(--line);
            border-radius: var(--radius-card);
            background: var(--surface);
            color: var(--muted-soft);
        }

        .modal-close {
            width: 44px;
            height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 7px;
        }

        .modal-close:focus-visible {
            outline: 3px solid rgba(54, 153, 255, .35);
            outline-offset: 2px;
        }

        @media (max-width: 720px) {
            .dashboard-wrapper {
                padding: 22px 18px 36px;
            }

            .dashboard-header {
                align-items: flex-start;
                flex-direction: column;
                gap: 14px;
                margin-bottom: 28px;
            }

            .dashboard-title {
                font-size: 25px;
            }

            .lectures-grid {
                max-width: none;
                grid-template-columns: 1fr;
            }

            .rooms-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .lecture-details {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 480px) {
            body {
                border-top-width: 7px;
            }

            .dashboard-wrapper {
                padding-right: 14px;
                padding-left: 14px;
            }

            .rooms-grid {
                grid-template-columns: 1fr;
            }

            .lecture-card {
                padding: 16px;
            }

            .lecture-top {
                gap: 10px;
            }

            .lecture-status {
                max-width: 104px;
            }

            .status-badge {
                white-space: normal;
                text-align: right;
            }

            .lecture-time {
                grid-template-columns: 1fr;
                gap: 5px;
            }

            .time-block:last-child {
                justify-content: flex-start;
            }

            .time-separator {
                display: none;
            }

            .lecture-details,
            .lecture-attendance {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .modal-panel {
                max-width: 100%;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .lecture-card,
            .room-card,
            .modal-panel,
            .lecture-progress .progress-fill {
                animation: none;
                transition: none;
            }

            .lecture-card:hover {
                transform: none;
            }
        }
    </style>

    <style>
        /* =========================================================
           MODAL REFINEMENT
        ========================================================== */

        .lecture-modal {
            align-items: stretch;
            background: rgba(15, 28, 39, .62);
            backdrop-filter: blur(6px);
        }

        .modal-panel {
            width: min(520px, 100vw);
            max-width: 100vw;
            height: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border-left: 1px solid rgba(16, 47, 94, .08);
            background: var(--surface);
            box-shadow: -18px 0 48px rgba(16, 47, 94, .18);
            scrollbar-gutter: stable;
        }

        .modal-header {
            flex: 0 0 auto;
            min-height: 96px;
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 22px 24px;
            background: var(--ink);
            color: var(--surface);
        }

        .modal-header.not-started {
            background: var(--ink);
        }

        .modal-header.waiting {
            background: var(--danger);
        }

        .modal-header.cancelled {
            background: var(--danger);
            color: var(--surface);
        }

        .modal-header.cancelled .modal-close:hover {
            background: rgba(255, 255, 255, .12);
        }

        .modal-header.in-progress,
        .modal-header.finished {
            background: var(--surface);
            color: var(--ink);
            border-bottom: 1px solid var(--line);
        }

        .modal-header-left {
            min-width: 0;
            flex: 1;
            gap: 12px;
        }

        .modal-icon {
            width: 46px;
            height: 46px;
            min-width: 46px;
            margin-right: 0;
            border: 1px solid var(--blue-line);
            border-radius: 12px;
            background: var(--blue-soft);
            box-shadow: none;
        }

        .modal-icon i {
            color: var(--blue);
        }

        .modal-title {
            max-width: 230px;
            overflow: hidden;
            color: inherit;
            font-size: 17px;
            line-height: 1.15;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .modal-trainer {
            max-width: 230px;
            margin-top: 6px;
            overflow: hidden;
            color: inherit;
            font-size: 11px;
            opacity: .78;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .modal-course {
            flex: 0 0 auto;
            max-width: 92px;
            overflow: hidden;
            color: inherit;
            font-size: 10px;
            letter-spacing: .04em;
            text-align: right;
            text-overflow: ellipsis;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .modal-close {
            flex: 0 0 44px;
            width: 44px;
            height: 44px;
            border: 1px solid currentColor;
            border-radius: 10px;
            color: inherit;
            opacity: .8;
            transition: background .18s ease, opacity .18s ease, transform .18s ease;
        }

        .modal-close:hover {
            background: rgba(255, 255, 255, .12);
            opacity: 1;
            transform: translateY(-1px);
        }

        .modal-header.in-progress .modal-close:hover,
        .modal-header.finished .modal-close:hover {
            background: var(--blue-soft);
        }

        .modal-body {
            flex: 1 1 auto;
            min-height: 0;
            overflow-y: auto;
            padding: 24px;
            background: #fbfcfe;
        }

        .modal-status-row {
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--line);
        }

        .modal-status {
            padding: 7px 11px;
            border: 1px solid var(--blue-line);
            border-radius: 999px;
            background: var(--blue-soft);
            color: #1769aa;
            font-size: 10px;
            letter-spacing: .01em;
        }

        .modal-time {
            color: var(--muted);
            font-size: 11px;
            font-variant-numeric: tabular-nums;
        }

        .details-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0;
            padding: 0;
            margin-bottom: 4px;
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: 12px;
            background: var(--surface);
        }

        .detail-box {
            min-width: 0;
            padding: 14px 13px;
            border-right: 1px solid var(--line);
        }

        .detail-label {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 7px;
            color: var(--muted);
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .05em;
            text-transform: uppercase;
        }

        .detail-label i {
            color: var(--blue);
        }

        .detail-value {
            display: block;
            overflow: hidden;
            color: var(--ink);
            font-size: 11px;
            line-height: 1.3;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .info-row {
            gap: 13px;
            padding: 15px 0;
            border-bottom-color: var(--line-soft);
        }

        .info-icon {
            width: 34px;
            height: 34px;
            min-width: 34px;
            border: 1px solid var(--blue-line);
            border-radius: 9px;
            background: var(--blue-soft);
            color: var(--blue);
        }

        .info-label {
            margin-bottom: 4px;
            color: var(--muted);
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .info-value {
            color: var(--ink);
            font-size: 12px;
        }

        .attendance-details {
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 8px;
            margin-top: 20px;
            padding: 0;
            border-bottom: 0;
        }

        .attendance-box {
            min-height: 68px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 10px 6px;
            border: 1px solid var(--line);
            border-radius: 10px;
            background: var(--surface);
        }

        .attendance-number {
            color: var(--ink);
            font-size: 18px;
            font-variant-numeric: tabular-nums;
        }

        .attendance-label {
            margin-top: 4px;
            color: var(--muted);
            font-size: 9px;
            font-weight: 700;
        }

        .attendance-percentage {
            margin-top: 20px;
            padding: 16px;
            border: 1px solid var(--blue-line);
            border-radius: 12px;
            background: var(--blue-soft);
        }

        .attendance-percentage-label {
            color: var(--muted);
            font-size: 10px;
            font-weight: 700;
        }

        .attendance-percentage-value {
            color: #1769aa;
            font-size: 22px;
            font-variant-numeric: tabular-nums;
        }

        .attendance-progress {
            height: 8px;
            background: #dceeff;
        }

        .attendance-progress-value {
            background: var(--blue);
        }

        .attendance-students {
            margin-top: 20px;
            padding: 16px;
            border: 1px solid var(--line);
            border-radius: 12px;
            background: var(--surface);
        }

        .attendance-students-title {
            color: var(--ink);
            font-size: 11px;
        }

        .attendance-students-count {
            min-width: 28px;
            height: 28px;
            background: var(--danger-soft);
            color: var(--danger);
            font-variant-numeric: tabular-nums;
        }

        .attendance-students-list {
            min-height: 76px;
            max-height: 280px;
        }

        .attendance-empty {
            color: var(--muted);
            font-size: 11px;
        }

        .attendance-student {
            padding: 12px;
            border-color: var(--line-soft);
            border-radius: 9px;
            background: #fbfcfe;
        }

        .student-name {
            color: var(--ink);
            font-size: 11px;
        }

        .student-meta-item {
            color: var(--muted);
            font-size: 9px;
        }

        .time-summary {
            margin-top: 20px;
            padding: 16px;
            border: 1px solid var(--line);
            border-radius: 12px;
            background: #f4f6f9;
        }

        .time-summary-icon,
        .time-summary-label,
        .time-summary-value {
            color: var(--ink);
        }

        .time-summary-value {
            font-size: 22px;
            font-variant-numeric: tabular-nums;
        }

        .duration-label {
            color: var(--muted);
            font-size: 9px;
        }

        .modal-header.waiting+.modal-body .time-summary,
        .modal-header.cancelled+.modal-body .time-summary {
            border-color: #ffd5d9;
            background: var(--danger-soft);
        }

        .modal-header.waiting+.modal-body .time-summary-icon,
        .modal-header.waiting+.modal-body .time-summary-label,
        .modal-header.waiting+.modal-body .time-summary-value,
        .modal-header.cancelled+.modal-body .time-summary-icon,
        .modal-header.cancelled+.modal-body .time-summary-label,
        .modal-header.cancelled+.modal-body .time-summary-value {
            color: var(--danger);
        }

        .modal-header.cancelled+.modal-body .modal-status {
            border-color: rgba(220, 53, 69, .2);
            background: rgba(220, 53, 69, .08);
            color: var(--danger);
        }

        .modal-header.in-progress+.modal-body .time-summary,
        .modal-header.finished+.modal-body .time-summary {
            border-color: var(--blue-line);
            background: var(--blue-soft);
        }

        .modal-header.in-progress+.modal-body .time-summary-icon,
        .modal-header.in-progress+.modal-body .time-summary-label,
        .modal-header.in-progress+.modal-body .time-summary-value,
        .modal-header.finished+.modal-body .time-summary-icon,
        .modal-header.finished+.modal-body .time-summary-label,
        .modal-header.finished+.modal-body .time-summary-value {
            color: #1769aa;
        }

        @media (max-width: 600px) {
            .modal-header {
                min-height: 88px;
                padding: 18px;
            }

            .modal-body {
                padding: 18px;
            }

            .modal-title,
            .modal-trainer {
                max-width: 160px;
            }

            .modal-course {
                max-width: 72px;
            }

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
    </style>

    <style>
        /* =========================================================
           UNIFORM LECTURE CARD + LIVE TIMELINE
        ========================================================== */

        :root {
            --lecture-card-height: 286px;
        }

        .lecture-card {
            height: var(--lecture-card-height);
            min-height: var(--lecture-card-height);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .lecture-top,
        .lecture-time,
        .lecture-details {
            flex: 0 0 auto;
        }

        .lecture-room {
            max-width: 230px;
            overflow: hidden;
            color: inherit;
            font-size: 15px;
            font-weight: 800;
            line-height: 1.2;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .lecture-card .course-code {
            display: block;
            margin-top: 4px;
            overflow: hidden;
            color: inherit;
            font-size: 10px;
            font-weight: 700;
            opacity: .82;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .lecture-not-started .course-code {
            color: var(--ink);
            opacity: 1;
        }

        .lecture-card .lecture-details {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 9px;
            margin-top: 15px;
        }

        .lecture-card .detail-item {
            min-width: 0;
        }

        .lecture-timeline {
            flex: 0 0 auto;
            margin-top: 17px;
        }

        .timeline-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 7px;
            color: var(--muted);
            font-size: 10px;
            font-weight: 800;
        }

        .timeline-header [data-remaining] {
            color: inherit;
            font-size: 11px;
            font-variant-numeric: tabular-nums;
            white-space: nowrap;
        }

        .timeline-track {
            width: 100%;
            height: 7px;
            overflow: hidden;
            border-radius: 999px;
            background: var(--line-soft);
        }

        .timeline-fill {
            width: 0;
            height: 100%;
            border-radius: inherit;
            background: var(--blue);
            transition: width .5s linear;
        }

        .lecture-not-started .timeline-header {
            color: var(--ink);
        }

        .lecture-not-started .timeline-track {
            background: rgba(255, 255, 255, .28);
        }

        .lecture-not-started .timeline-fill {
            background: var(--ink);
        }

        .lecture-waiting .timeline-header {
            color: var(--surface);
        }

        .lecture-waiting .timeline-track {
            background: rgba(0, 0, 0, .18);
        }

        .lecture-waiting .timeline-fill {
            background: var(--surface);
        }

        .lecture-in-progress .timeline-header,
        .lecture-finished .timeline-header {
            color: var(--muted);
        }

        .lecture-in-progress .timeline-fill,
        .lecture-finished .timeline-fill {
            background: var(--blue);
        }

        .lecture-card .lecture-footer {
            flex: 0 0 auto;
            margin-top: auto;
        }

        .lecture-card .lecture-progress,
        .lecture-card .lecture-attendance {
            display: none;
        }

        @media (max-width: 720px) {
            :root {
                --lecture-card-height: 300px;
            }

            .lecture-room {
                max-width: 170px;
            }
        }

        @media (max-width: 480px) {
            :root {
                --lecture-card-height: 300px;
            }

            .lecture-room {
                max-width: 150px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .timeline-fill {
                transition: none;
            }
        }
    </style>

    <style>
        /* =========================================================
           DENSE PROFESSIONAL LECTURE CARD
        ========================================================== */

        :root {
            --lecture-card-height: 208px;
        }

        .lecture-card {
            padding: 11px;
        }

        .lecture-top {
            gap: 8px;
        }

        .lecture-icon {
            width: 38px;
            height: 38px;
            min-width: 38px;
            margin-right: 8px;
            border-radius: 8px;
        }

        .lecture-room {
            max-width: 210px;
            font-size: 13px;
        }

        .lecture-card .course-code {
            margin-top: 1px;
            font-size: 8px;
        }

        .lecture-waiting .course-code {
            color: var(--surface);
            opacity: 1;
        }

        .lecture-time {
            gap: 6px;
            margin-top: 10px;
            padding: 6px 8px;
            box-shadow: none;
            font-size: 10px;
        }

        .lecture-card .lecture-details {
            grid-template-columns: minmax(0, 1fr);
            gap: 4px;
            margin-top: 6px;
        }

        .lecture-card .detail-item {
            gap: 4px;
            font-size: 9px;
        }

        .lecture-attendance-rate {
            flex: 0 0 auto;
            margin-top: 6px;
            padding: 3px 0;
            border: 0;
            border-radius: 0;
            background: transparent;
            color: var(--ink);
        }

        .attendance-rate-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 4px;
            color: var(--muted);
            font-size: 8px;
            font-weight: 800;
            letter-spacing: .02em;
            text-transform: uppercase;
        }

        .attendance-rate-header [data-attendance-rate] {
            color: #1769aa;
            font-size: 10px;
            font-variant-numeric: tabular-nums;
        }

        .attendance-rate-track {
            height: 4px;
            overflow: hidden;
            border-radius: 999px;
            background: #dceeff;
        }

        .attendance-rate-fill {
            width: 0;
            height: 100%;
            border-radius: inherit;
            background: var(--blue);
        }

        .lecture-not-started .lecture-attendance-rate {
            background: transparent;
            color: var(--ink);
        }

        .lecture-not-started .attendance-rate-header,
        .lecture-not-started .attendance-rate-header [data-attendance-rate] {
            color: var(--ink);
        }

        .lecture-not-started .attendance-rate-track {
            background: rgba(255, 255, 255, .35);
        }

        .lecture-not-started .attendance-rate-fill {
            background: var(--ink);
        }

        .lecture-waiting .lecture-attendance-rate {
            background: transparent;
            color: var(--surface);
        }

        .lecture-waiting .attendance-rate-header,
        .lecture-waiting .attendance-rate-header [data-attendance-rate] {
            color: var(--surface);
        }

        .lecture-waiting .attendance-rate-track {
            background: rgba(0, 0, 0, .2);
        }

        .lecture-waiting .attendance-rate-fill {
            background: var(--surface);
        }

        .lecture-in-progress .lecture-attendance-rate,
        .lecture-finished .lecture-attendance-rate {
            background: transparent;
        }

        .lecture-timeline {
            margin-top: 5px;
        }

        .timeline-header {
            margin-bottom: 2px;
            font-size: 8px;
        }

        .timeline-header [data-remaining] {
            font-size: 9px;
        }

        .timeline-track {
            height: 4px;
            box-shadow: none;
        }

        .lecture-card .lecture-footer {
            padding-top: 4px;
            border-top: 0;
        }

        .lecture-card .lecture-footer>div {
            font-size: 8px;
        }

        @media (max-width: 720px) {
            :root {
                --lecture-card-height: 222px;
            }
        }

        @media (max-width: 480px) {
            :root {
                --lecture-card-height: 228px;
            }
        }
    </style>

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


            <div class="total-badge" id="totalCount" aria-live="polite">

                <i class="fas fa-layer-group" aria-hidden="true"></i>

                Total:
                {{ $lectures->count() + $availableRooms->count() }}

            </div>

        </div>


        {{-- =========================================================
         LECTURES HEADER
    ========================================================== --}}

        <div class="section-header">

            <div class="section-title">

                <i class="fas fa-chalkboard-teacher" style="color: var(--blue);" aria-hidden="true"></i>

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


        {{-- =========================================================
         AVAILABLE ROOMS
    ========================================================== --}}

        <div class="section-header">

            <div class="section-title">

                <i class="fas fa-door-open" style="color: var(--teal);" aria-hidden="true"></i>

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


    </main>



    {{-- =============================================================
     MODAL
============================================================== --}}

    <div class="lecture-modal" id="lectureModal" role="dialog" aria-modal="true" aria-labelledby="lectureModalTitle"
        aria-hidden="true">


        <div class="modal-panel">


            {{-- =====================================================
             HEADER
        ====================================================== --}}

            <div class="modal-header not-started" data-modal-header>


                <div class="modal-header-left">


                    <div class="modal-icon">

                        <i class="fas fa-chalkboard-teacher"></i>

                    </div>


                    <div>

                        <div class="modal-title" id="lectureModalTitle" data-modal-batch>
                            -
                        </div>


                        <div class="modal-trainer" data-modal-trainer>
                            -
                        </div>

                    </div>


                </div>


                <div class="modal-course" data-modal-course>
                    -
                </div>


                <button type="button" class="modal-close" id="closeLectureModal" aria-label="Close lecture details">

                    <i class="fas fa-times" aria-hidden="true"></i>

                </button>


            </div>


            {{-- =====================================================
             BODY
        ====================================================== --}}

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

        const lectureModal =
            document.getElementById(
                'lectureModal'
            );

        const closeLectureModal =
            document.getElementById(
                'closeLectureModal'
            );

        let selectedLecture = null;
        let lastFocusedLecture = null;
        let attendanceBySchedule = {};


        /* ============================================================
           DATE PARSER
        ============================================================ */

        function parseDateTime(value) {

            if (!value) {
                return null;
            }

            return new Date(
                value
                .trim()
                .replace(' ', 'T')
            );
        }


        /* ============================================================
           FORMAT REMAINING
        ============================================================ */

        function formatRemaining(seconds) {

            seconds =
                Math.max(
                    0,
                    Math.floor(seconds)
                );

            const hours =
                Math.floor(
                    seconds / 3600
                );

            const minutes =
                Math.floor(
                    (seconds % 3600) / 60
                );

            const secs =
                seconds % 60;

            return (
                String(hours).padStart(2, '0') +
                ':' +
                String(minutes).padStart(2, '0') +
                ':' +
                String(secs).padStart(2, '0')
            );
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
