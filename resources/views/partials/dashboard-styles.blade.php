
<style>
   
   
    :root {
        --page-bg: #f4f6f9;
        --top-accent: #263c3f;
        --surface: #ffffff;
        --ink: #102f5e;
        --ink-soft: #344054;
        --muted: #5e6c84;
        --teal: #1bc5bd;
        --teal-ink: #006b66;
        --teal-soft: #e8fbfa;
        --line: #e1e6ee;
        --line-soft: #eef1f5;
        --blue: #3699ff;
        --blue-soft: #eef7ff;
        --blue-line: #cfe7ff;
        --blue-strong: #1769aa;
        --danger: #dc3545;
        --danger-soft: #fff2f3;
        --not-started-bg: #a6a6a6;
        --shadow-card: 0 10px 24px rgba(16, 47, 94, .08);
        --shadow-card-hover: 0 14px 30px rgba(16, 47, 94, .14);
        --radius-card: 10px;
        --radius-control: 8px;
        --top-bar: 10px;
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
        background: var(--page-bg);
        color: var(--ink);
        border-top: var(--top-bar) solid var(--top-accent);
        font-family: Arial, Helvetica, sans-serif;
    }

    /* ==========================================================
       PAGE / LAYOUT  (fluid, never scrolls)
       --k  : lecture card scale factor (set by JS)
       --rk : room card scale factor (set by JS)
    ========================================================== */
    .dashboard-wrapper {
        width: 100%;
        height: calc(100dvh - var(--top-bar));
        max-height: calc(100dvh - var(--top-bar));
        padding: clamp(6px, 1.1vh, 14px) clamp(6px, 1vw, 18px);
        display: flex;
        flex-direction: column;
        gap: clamp(4px, .8vh, 10px);
        overflow: hidden;
    }

    .dashboard-header {
        flex: 0 0 auto;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 8px;
    }

    .dashboard-title {
        margin: 0;
        color: var(--ink);
        font-size: clamp(18px, 2.3vh, 28px);
        font-weight: 800;
        line-height: 1.1;
        letter-spacing: -.02em;
    }

    .dashboard-date {
        margin-top: 3px;
        color: var(--muted);
        font-size: clamp(9px, 1.1vh, 12px);
        font-weight: 600;
        letter-spacing: .01em;
    }

    .dashboard-summary {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        flex-wrap: wrap;
        gap: 6px;
    }

    .total-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        min-height: 0;
        padding: clamp(4px, .8vh, 10px) clamp(7px, .8vw, 14px);
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: var(--radius-control);
        color: var(--muted);
        font-size: clamp(8px, 1vh, 11px);
        font-weight: 700;
        white-space: nowrap;
    }

    .total-badge i {
        margin-right: 4px;
        color: var(--ink);
    }

    .summary-value {
        color: var(--ink);
        font-size: clamp(10px, 1.25vh, 14px);
        font-variant-numeric: tabular-nums;
    }

    .dashboard-content {
        flex: 1 1 auto;
        min-height: 0;
        display: flex;
        flex-direction: column;
        gap: clamp(4px, .8vh, 12px);
        overflow: hidden;
    }

    .dashboard-section,
    .lectures-section {
        flex: 1 1 0;
        min-height: 0;
        display: flex;
        flex-direction: column;
        min-width: 0;
        overflow: hidden;
    }

    .section-header {
        flex: 0 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin: 0 0 clamp(3px, .6vh, 8px);
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--ink);
        font-size: clamp(11px, 1.5vh, 15px);
        font-weight: 800;
        letter-spacing: -.01em;
    }

    .section-title i {
        font-size: clamp(12px, 1.6vh, 16px);
    }

    .section-count {
        padding: clamp(3px, .6vh, 8px) clamp(6px, .7vw, 11px);
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: var(--radius-control);
        color: var(--muted);
        font-size: clamp(8px, .95vh, 10px);
        font-weight: 700;
    }

    /* ==========================================================
       GRIDS (cols / rows / gaps are injected by Blade + JS)
    ========================================================== */
    .lectures-grid,
    .rooms-grid {
        --gap: clamp(4px, .5vw, 14px);
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
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: var(--radius-card);
        color: var(--muted);
        font-size: clamp(9px, 1.2vh, 12px);
        text-align: center;
    }
    /* ==========================================================
       LECTURE CARD
    ========================================================== */
    .lecture-card {
        position: relative;
        width: 100%;
        min-width: 0;
        height: 100%;
        min-height: 0;
        padding: calc(8px * var(--k, 1));
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: calc(3px * var(--k, 1));
        overflow: hidden;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: clamp(5px, calc(10px * var(--k, 1)), 10px);
        box-shadow: 0 calc(2px * var(--k, 1)) calc(6px * var(--k, 1)) rgba(0, 0, 0, .05);
        color: var(--ink);
        line-height: 1.1;
        cursor: pointer;
        transition: transform .2s ease, box-shadow .2s ease;
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

    /* --- states ------------------------------------------ */
    .lecture-not-started {
        background: var(--not-started-bg);
        border-color: rgba(0, 0, 0, .12);
        box-shadow: 0 8px 18px rgba(0, 0, 0, .08);
        color: var(--ink);
    }

    .lecture-waiting,
    .lecture-cancelled {
        background: var(--danger);
        border-color: var(--danger);
        color: var(--surface);
    }

    .lecture-in-progress,
    .lecture-finished {
        background: var(--surface);
        border-color: var(--line);
        color: var(--ink);
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
        align-items: flex-start;
    }

    .lecture-icon {
        width: calc(38px * var(--k, 1));
        height: calc(38px * var(--k, 1));
        min-width: calc(18px * var(--k, 1));
        margin-right: calc(8px * var(--k, 1));
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: calc(8px * var(--k, 1));
        background: var(--surface);
        box-shadow: 0 2px 5px rgba(16, 47, 94, .08);
    }

    .lecture-icon i {
        color: var(--blue);
        font-size: calc(21px * var(--k, 1));
    }

    .lecture-not-started .lecture-icon i {
        color: #000000;
    }

    .lecture-waiting .lecture-icon i,
    .lecture-cancelled .lecture-icon i {
        color: var(--danger);
    }

    .lecture-info {
        flex: 1;
        min-width: 0;
    }

    .lecture-room {
        min-width: 0;
        overflow: hidden;
        color: inherit;
        font-size: calc(13px * var(--k, 1));
        font-weight: 800;
        line-height: 1.15;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .course-code {
        display: block;
        margin-top: calc(1px * var(--k, 1));
        overflow: hidden;
        color: inherit;
        font-size: calc(8.5px * var(--k, 1));
        font-weight: 700;
        opacity: .82;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .lecture-not-started .course-code {
        color: var(--ink);
        opacity: 1;
    }

    .lecture-waiting .course-code,
    .lecture-cancelled .course-code {
        color: var(--surface);
        opacity: 1;
    }

    /* --- section badge (top inline-end corner) ----------- */
    .lecture-section {
        flex: 0 0 auto;
        max-width: 46%;
        margin-inline-start: auto;
        display: inline-flex;
        align-items: center;
        gap: calc(4px * var(--k, 1));
        padding: calc(1.5px * var(--k, 1)) calc(5px * var(--k, 1));
        overflow: hidden;
        border: 1px solid var(--line);
        border-radius: 999px;
        background: var(--blue-soft);
        color: var(--ink);
        font-size: calc(9px * var(--k, 1));
        font-weight: 800;
        line-height: 1.25;
    }

    .lecture-section i {
        flex: 0 0 auto;
        color: var(--muted);
        font-size: calc(8.5px * var(--k, 1));
    }

    .lecture-section span {
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .lecture-not-started .lecture-section {
        background: rgba(255, 255, 255, .6);
        border-color: rgba(16, 47, 94, .14);
    }

    .lecture-waiting .lecture-section,
    .lecture-cancelled .lecture-section {
        background: rgba(0, 0, 0, .14);
        border-color: rgba(255, 255, 255, .42);
        color: var(--surface);
    }

    .lecture-waiting .lecture-section i,
    .lecture-cancelled .lecture-section i {
        color: rgba(255, 255, 255, .84);
    }

    /* --- time -------------------------------------------- */
    .lecture-time {
        flex: 0 0 auto;
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        gap: calc(5px * var(--k, 1));
        margin-top: calc(8px * var(--k, 1));
        padding: calc(5px * var(--k, 1)) calc(7px * var(--k, 1));
        border-radius: calc(7px * var(--k, 1));
        background: var(--blue-soft);
        color: var(--ink);
        font-size: calc(10.5px * var(--k, 1));
        font-weight: 800;
    }

    .lecture-not-started .lecture-time {
        background: rgba(255, 255, 255, .18);
    }

    .lecture-waiting .lecture-time,
    .lecture-cancelled .lecture-time {
        background: rgba(0, 0, 0, .12);
        color: var(--surface);
    }

    .time-block {
        min-width: 0;
        display: inline-flex;
        align-items: center;
        gap: calc(6px * var(--k, 1));
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .time-block:last-child {
        justify-content: flex-end;
    }

    .time-separator {
        color: var(--muted);
        font-weight: 400;
    }

    .lecture-waiting .time-separator,
    .lecture-cancelled .time-separator {
        color: rgba(255, 255, 255, .7);
    }

    /* --- details (trainer) ------------------------------- */
    .lecture-details {
        flex: 0 0 auto;
        display: flex;
        align-items: center;
        margin-top: calc(5px * var(--k, 1));
        padding-top: calc(4px * var(--k, 1));
        border-top: 1px solid var(--line);
    }

    .detail-item {
        min-width: 0;
        width: 100%;
        display: flex;
        align-items: center;
        gap: calc(5px * var(--k, 1));
        color: inherit;
        font-size: calc(9.5px * var(--k, 1));
        font-weight: 700;
        line-height: 1.15;
    }

    .detail-avatar {
        flex: 0 0 auto;
        width: calc(13px * var(--k, 1));
        height: calc(13px * var(--k, 1));
        display: grid;
        place-items: center;
        border-radius: 50%;
        background: var(--blue-soft);
        color: var(--blue);
        font-size: max(5.5px, calc(7px * var(--k, 1)));
        font-weight: 800;
        letter-spacing: .02em;
        line-height: 1;
    }

    .detail-text {
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
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
        font-weight: 800;
        font-variant-numeric: tabular-nums;
        white-space: nowrap;
    }

    .lecture-not-started .lecture-details {
        border-top-color: rgba(16, 47, 94, .12);
    }

    .lecture-not-started .detail-avatar {
        background: rgba(255, 255, 255, .72);
        color: var(--ink);
    }

    .lecture-waiting .lecture-details,
    .lecture-cancelled .lecture-details {
        border-top-color: rgba(255, 255, 255, .26);
    }

    .lecture-waiting .detail-avatar,
    .lecture-cancelled .detail-avatar {
        background: rgba(0, 0, 0, .18);
        color: var(--surface);
    }

    .lecture-waiting .detail-meta,
    .lecture-cancelled .detail-meta {
        color: rgba(255, 255, 255, .84);
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
        font-weight: 800;
        letter-spacing: .02em;
        line-height: 1.1;
        text-transform: uppercase;
    }

    .attendance-rate-header [data-attendance-rate] {
        color: var(--blue-strong);
        font-size: calc(10px * var(--k, 1));
        font-variant-numeric: tabular-nums;
    }

    .attendance-rate-track {
        height: calc(4px * var(--k, 1));
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

    .lecture-waiting .attendance-rate-header,
    .lecture-waiting .attendance-rate-header [data-attendance-rate],
    .lecture-cancelled .attendance-rate-header,
    .lecture-cancelled .attendance-rate-header [data-attendance-rate] {
        color: var(--surface);
    }

    .lecture-waiting .attendance-rate-track,
    .lecture-cancelled .attendance-rate-track {
        background: rgba(0, 0, 0, .2);
    }

    .lecture-waiting .attendance-rate-fill,
    .lecture-cancelled .attendance-rate-fill {
        background: var(--surface);
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
        font-weight: 800;
        line-height: 1.1;
    }

    .timeline-header [data-remaining] {
        color: inherit;
        font-size: calc(9.5px * var(--k, 1));
        font-variant-numeric: tabular-nums;
        white-space: nowrap;
    }

    .timeline-track {
        width: 100%;
        height: calc(4px * var(--k, 1));
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

    .lecture-waiting .timeline-header,
    .lecture-cancelled .timeline-header {
        color: var(--surface);
    }

    .lecture-waiting .timeline-track,
    .lecture-cancelled .timeline-track {
        background: rgba(0, 0, 0, .18);
    }

    .lecture-waiting .timeline-fill,
    .lecture-cancelled .timeline-fill {
        background: var(--surface);
    }

    /* ==========================================================
       ROOM CARDS
    ========================================================== */
    .room-card {
        width: 100%;
        min-width: 0;
        height: 100%;
        min-height: 0;
        padding: calc(8px * var(--rk, 1)) calc(9px * var(--rk, 1));
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        gap: calc(4px * var(--rk, 1));
        overflow: hidden;
        background: var(--surface);
        border: 1px dashed var(--teal);
        border-radius: clamp(5px, calc(8px * var(--rk, 1)), 8px);
        box-shadow: 0 calc(2px * var(--rk, 1)) calc(6px * var(--rk, 1)) rgba(16, 47, 94, .07);
        line-height: 1.1;
    }

    .room-header {
        min-width: 0;
        display: flex;
        align-items: center;
        gap: calc(7px * var(--rk, 1));
    }

    .room-icon {
        width: calc(30px * var(--rk, 1));
        height: calc(30px * var(--rk, 1));
        min-width: calc(16px * var(--rk, 1));
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: calc(6px * var(--rk, 1));
        background: var(--teal);
    }

    .room-icon i {
        color: var(--surface);
        font-size: calc(14px * var(--rk, 1));
    }

    .room-code {
        max-width: 100%;
        overflow: hidden;
        color: var(--ink);
        font-size: calc(15px * var(--rk, 1));
        font-weight: 800;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .room-status {
        max-width: 100%;
        overflow: hidden;
        color: var(--teal);
        font-size: calc(10.5px * var(--rk, 1));
        font-weight: 700;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .room-free {
        max-width: 100%;
        flex: 0 0 auto;
        padding: calc(2px * var(--rk, 1)) calc(6px * var(--rk, 1));
        background: var(--teal-soft);
        border-radius: calc(4px * var(--rk, 1));
        color: var(--ink);
        font-size: calc(9.5px * var(--rk, 1));
        font-weight: 700;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* ==========================================================
       MODAL
    ========================================================== */
    .lecture-modal {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: none;
        align-items: stretch;
        justify-content: flex-end;
        background: rgba(15, 28, 39, .62);
        backdrop-filter: blur(6px);
    }

    .lecture-modal.active {
        display: flex;
    }

    .modal-panel {
        width: min(520px, 100vw);
        max-width: 100vw;
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        background: var(--surface);
        border-left: 1px solid rgba(16, 47, 94, .08);
        box-shadow: -18px 0 48px rgba(16, 47, 94, .18);
        scrollbar-gutter: stable;
        animation: slideIn .25s ease;
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
        min-height: 96px;
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 22px 24px;
        background: var(--ink);
        color: var(--surface);
    }

    .modal-header.waiting,
    .modal-header.cancelled {
        background: var(--danger);
        color: var(--surface);
    }

    .modal-header.not-started {
        background: var(--ink);
    }

    .modal-header.in-progress,
    .modal-header.finished {
        background: var(--surface);
        color: var(--ink);
        border-bottom: 1px solid var(--line);
    }

    .modal-header-left {
        flex: 1;
        min-width: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .modal-icon {
        width: 46px;
        height: 46px;
        min-width: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--blue-line);
        border-radius: 12px;
        background: var(--blue-soft);
    }

    .modal-icon i {
        color: var(--blue);
        font-size: 21px;
    }

    .modal-title {
        max-width: 230px;
        margin: 0;
        overflow: hidden;
        color: inherit;
        font-size: 17px;
        font-weight: 800;
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
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid currentColor;
        border-radius: 10px;
        background: transparent;
        color: inherit;
        font-size: 20px;
        opacity: .8;
        cursor: pointer;
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

    .modal-close:focus-visible {
        outline: 3px solid rgba(54, 153, 255, .35);
        outline-offset: 2px;
    }
    .modal-body {
        flex: 1 1 auto;
        min-height: 0;
        padding: 24px;
        overflow-y: auto;
        background: #fbfcfe;
    }

    .modal-status-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--line);
    }

    .modal-status {
        display: inline-block;
        padding: 7px 11px;
        background: var(--blue-soft);
        border: 1px solid var(--blue-line);
        border-radius: 999px;
        color: var(--blue-strong);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .01em;
    }

    .modal-time {
        color: var(--muted);
        font-size: 11px;
        font-weight: 700;
        font-variant-numeric: tabular-nums;
    }

    .details-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        margin-bottom: 4px;
        overflow: hidden;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 12px;
    }

    .detail-box {
        min-width: 0;
        padding: 14px 13px;
        border-right: 1px solid var(--line);
    }

    .detail-box:first-child {
        padding-left: 14px;
    }

    .detail-box:last-child {
        padding-right: 14px;
        border-right: 0;
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
        font-weight: 700;
        line-height: 1.3;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .info-row {
        display: flex;
        align-items: flex-start;
        gap: 13px;
        padding: 15px 0;
        border-bottom: 1px solid var(--line-soft);
    }

    .info-icon {
        width: 34px;
        height: 34px;
        min-width: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
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
        font-weight: 700;
        word-break: break-word;
    }
    .attendance-details {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 8px;
        margin-top: 20px;
    }

    .attendance-box {
        min-height: 68px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 10px 6px;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 10px;
        text-align: center;
    }

    .attendance-number {
        display: block;
        color: var(--ink);
        font-size: 18px;
        font-weight: 800;
        font-variant-numeric: tabular-nums;
    }

    .attendance-label {
        display: block;
        margin-top: 4px;
        color: var(--muted);
        font-size: 9px;
        font-weight: 700;
    }

    .attendance-percentage {
        margin-top: 20px;
        padding: 16px;
        background: var(--blue-soft);
        border: 1px solid var(--blue-line);
        border-radius: 12px;
    }

    .attendance-percentage-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 9px;
    }

    .attendance-percentage-label {
        color: var(--muted);
        font-size: 10px;
        font-weight: 700;
    }

    .attendance-percentage-value {
        color: var(--blue-strong);
        font-size: 22px;
        font-weight: 800;
        font-variant-numeric: tabular-nums;
    }

    .attendance-progress {
        width: 100%;
        height: 8px;
        overflow: hidden;
        border-radius: 999px;
        background: #dceeff;
    }

    .attendance-progress-value {
        width: 0%;
        height: 100%;
        border-radius: inherit;
        background: var(--blue);
        transition: width .4s ease;
    }

    .attendance-students {
        margin-top: 20px;
        padding: 16px;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 12px;
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
        color: var(--ink);
        font-size: 11px;
        font-weight: 800;
    }

    .attendance-students-title i {
        color: var(--danger);
    }

    .attendance-students-count {
        min-width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 7px;
        background: var(--danger-soft);
        border-radius: 50%;
        color: var(--danger);
        font-size: 10px;
        font-weight: 800;
        font-variant-numeric: tabular-nums;
    }

    .attendance-students-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
        min-height: 76px;
        max-height: 280px;
        overflow-y: auto;
    }

    .attendance-student {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 12px;
        background: #fbfcfe;
        border: 1px solid var(--line-soft);
        border-radius: 9px;
    }

    .student-info {
        flex: 1;
        min-width: 0;
    }

    .student-name {
        color: var(--ink);
        font-size: 11px;
        font-weight: 800;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .student-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 5px;
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
    }

    .student-status {
        flex-shrink: 0;
        padding: 5px 8px;
        background: var(--danger-soft);
        border-radius: 5px;
        color: var(--danger);
        font-size: 8px;
        font-weight: 800;
    }

    .attendance-loading {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 25px 10px;
        color: var(--muted);
        font-size: 10px;
        font-weight: 600;
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
        color: var(--teal);
        font-size: 20px;
    }
    .time-summary {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-top: 20px;
        padding: 16px;
        background: #f4f6f9;
        border: 1px solid var(--line);
        border-radius: 12px;
    }

    .time-summary-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .time-summary-icon {
        color: var(--ink);
        font-size: 20px;
    }

    .time-summary-label {
        color: var(--ink);
        font-size: 10px;
        font-weight: 700;
    }

    .time-summary-value {
        margin-top: 2px;
        color: var(--ink);
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
    }

    .duration-value {
        margin-top: 3px;
        color: var(--ink);
        font-size: 12px;
        font-weight: 800;
    }

    /* --- status tinted time summary ---------------------- */
    .modal-header.waiting+.modal-body .time-summary,
    .modal-header.cancelled+.modal-body .time-summary {
        background: var(--danger-soft);
        border-color: #ffd5d9;
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
        background: rgba(220, 53, 69, .08);
        border-color: rgba(220, 53, 69, .2);
        color: var(--danger);
    }

    .modal-header.in-progress+.modal-body .time-summary,
    .modal-header.finished+.modal-body .time-summary {
        background: var(--blue-soft);
        border-color: var(--blue-line);
    }

    .modal-header.in-progress+.modal-body .time-summary-icon,
    .modal-header.in-progress+.modal-body .time-summary-label,
    .modal-header.in-progress+.modal-body .time-summary-value,
    .modal-header.finished+.modal-body .time-summary-icon,
    .modal-header.finished+.modal-body .time-summary-label,
    .modal-header.finished+.modal-body .time-summary-value {
        color: var(--blue-strong);
    }

    /* ==========================================================
       DENSITY TIERS
       data-density is set by the layout engine on each grid.
       "ultra" keeps only the essentials so nothing is clipped
       when dozens of cards share a small screen.
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
       Grid cols/rows are computed per item count (Blade + JS),
       so media queries only tune chrome (header / modal).
    ========================================================== */
    @media (max-width: 720px) {
        .dashboard-header {
            align-items: flex-start;
            flex-direction: column;
            gap: 6px;
        }

        .dashboard-summary {
            justify-content: flex-start;
            width: 100%;
        }

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
            --top-bar: 7px;
        }

        .dashboard-wrapper {
            padding: 7px;
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
</style>
