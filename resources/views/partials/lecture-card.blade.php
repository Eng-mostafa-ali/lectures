<div class="lecture-card {{ $item->status === 'cancelled' ? 'lecture-cancelled' : ($item->status === 'in_progress' ? 'lecture-in-progress' : ($item->status === 'finished' ? 'lecture-finished' : 'lecture-not-started')) }}"
    data-lecture-card role="button" tabindex="0" aria-label="{{ $item->aria_label }}"
    data-schedule-id="{{ $item->schedule_id }}" data-status="{{ $item->status }}" data-start="{{ $item->start_datetime }}"
    data-end="{{ $item->end_datetime }}" data-room="{{ $item->room_code }}" data-delivery="{{ $item->delivery_mode }}"
    data-online-link="{{ $item->online_link }}" data-course="{{ $item->course_name }}"
    data-course-code="{{ $item->course_code }}" data-batch="{{ $item->batch_name }}"
    data-batch-code="{{ $item->batch_code }}" data-section="{{ $item->section_name }}"
    data-section-code="{{ $item->section_code }}" data-trainer="{{ $item->trainer_name }}"
    data-trainees="{{ $item->trainee_count }}" data-present="{{ $item->present_count }}"
    data-absent="{{ $item->absent_count }}" data-late="{{ $item->late_count }}"
    data-excused="{{ $item->excused_count }}" data-attendance-percentage="{{ $item->attendance_percentage }}"
    data-trainer-id="{{ $item->trainer_id }}">

    {{-- Header --}}
    <div class="lecture-top">
        <div class="lecture-main">
            <div class="lecture-icon">
                <i class="fas fa-chalkboard-teacher" aria-hidden="true"></i>
            </div>

            <div class="lecture-info">
                <div class="lecture-room">
                    {{ $item->room_label }}
                </div>

                <div class="course-code">
                    {{ $item->course_code }}
                </div>
            </div>
        </div>
    </div>

    {{-- Time --}}
    <div class="lecture-time">
        <div class="time-block">
            <i class="far fa-clock" aria-hidden="true"></i>

            <span>
                {{ $item->start_formatted }}
            </span>
        </div>

        <span class="time-separator">-</span>

        <div class="time-block">
            <span>
                {{ $item->end_formatted }}
            </span>
        </div>
    </div>

    {{-- Trainer --}}
    <div class="lecture-details">
        <div class="detail-item">
            <i class="fas fa-user-tie" aria-hidden="true"></i>

            <span>
                {{ $item->trainer_name }}
            </span>
        </div>
    </div>

    @if ($item->status === 'in_progress')
        {{-- Attendance --}}
        <div class="lecture-attendance-rate">
            <div class="attendance-rate-header">
                <span>Attendance</span>

                <span data-attendance-rate>
                    {{ $item->attendance_percentage_formatted }}%
                </span>
            </div>

            <div class="attendance-rate-track">
                <div class="attendance-rate-fill" style="width: {{ $item->attendance_progress }}%"></div>
            </div>
        </div>
    @endif

    {{-- Timeline --}}
    <div class="lecture-timeline">
        <div class="timeline-header">
            <span data-timeline-label>Starts in</span>
            <span data-remaining>--:--:--</span>
        </div>

        <div class="timeline-track" role="progressbar" aria-label="Lecture duration" aria-valuemin="0"
            aria-valuemax="100" aria-valuenow="0">
            <div class="timeline-fill" data-progress style="width: 0%"></div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="lecture-footer">
        <div>
            <i class="fas fa-users" aria-hidden="true"></i>
            {{ $item->section_code }}
        </div>
    </div>
</div>
