<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>My Lectures</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px;
            background: #f4f6f9;
            font-family: Arial, Helvetica, sans-serif;
            color: #172b4d;
        }

        .container {
            max-width: 1400px;
            margin: auto;
        }

        .header {
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0;
            font-size: 25px;
        }

        .header p {
            color: #7a869a;
            font-size: 13px;
        }

        .lectures {
            display: grid;
            grid-template-columns:
                repeat(auto-fill, minmax(330px, 1fr));

            gap: 18px;
        }

        .lecture {
            background: white;
            border-radius: 10px;
            padding: 18px;
            border: 1px solid #e4e7ec;
            box-shadow:
                0 4px 12px rgba(0, 0, 0, .05);
        }

        .lecture-header {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .course {
            font-size: 15px;
            font-weight: 800;
        }

        .course-code {
            margin-top: 4px;
            font-size: 10px;
            color: #7a869a;
        }

        .status {
            padding: 6px 9px;
            border-radius: 5px;
            font-size: 9px;
            font-weight: 800;
        }

        .status-not_started {
            background: #eef0f3;
            color: #5e6c84;
        }

        .status-in_progress {
            background: #e9f7ef;
            color: #198754;
        }

        .status-finished {
            background: #eef2f7;
            color: #172b4d;
        }

        .status-cancelled {
            background: #fff2f3;
            color: #dc3545;
        }

        .info {
            margin-top: 18px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .info-item {
            padding: 10px;
            background: #f8f9fb;
            border-radius: 6px;
        }

        .label {
            font-size: 9px;
            color: #7a869a;
        }

        .value {
            margin-top: 4px;
            font-size: 11px;
            font-weight: 700;
        }

        .actions {
            display: flex;
            gap: 8px;
            margin-top: 18px;
        }

        button,
        .attendance-btn {
            border: 0;
            border-radius: 6px;
            padding: 9px 12px;
            font-size: 10px;
            font-weight: 800;
            cursor: pointer;
        }

        .start-btn {
            background: #3699ff;
            color: white;
        }

        .finish-btn {
            background: #198754;
            color: white;
        }

        .cancel-btn {
            background: #dc3545;
            color: white;
        }

        .attendance-btn {
            background: #172b4d;
            color: white;
            text-decoration: none;
        }

        .empty {
            background: white;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            color: #7a869a;
        }

    </style>

</head>

<body>

<div class="container">

    <div class="header">

        <h1>
            My Lectures
        </h1>

        <p>
            {{ now()->format('Y-m-d') }}
        </p>

    </div>


    <div class="lectures">

        @forelse($lectures as $lecture)

            <div
                class="lecture"
                data-lecture
                data-id="{{ $lecture->schedule_id }}"
            >

                <div class="lecture-header">

                    <div>

                        <div class="course">

                            {{ $lecture->course_name }}

                        </div>

                        <div class="course-code">

                            {{ $lecture->course_code }}

                        </div>

                    </div>


                    <div
                        class="status status-{{ $lecture->status }}"
                        data-status
                    >

                        {{ str_replace('_', ' ', ucfirst($lecture->status)) }}

                    </div>

                </div>


                <div class="info">

                    <div class="info-item">

                        <div class="label">
                            Time
                        </div>

                        <div class="value">

                            {{ \Carbon\Carbon::parse($lecture->start_time)->format('h:i A') }}

                            -

                            {{ \Carbon\Carbon::parse($lecture->end_time)->format('h:i A') }}

                        </div>

                    </div>


                    <div class="info-item">

                        <div class="label">
                            Room
                        </div>

                        <div class="value">

                            {{ $lecture->room_code ?? 'Online' }}

                        </div>

                    </div>


                    <div class="info-item">

                        <div class="label">
                            Batch
                        </div>

                        <div class="value">

                            {{ $lecture->batch_code }}

                        </div>

                    </div>


                    <div class="info-item">

                        <div class="label">
                            Section
                        </div>

                        <div class="value">

                            {{ $lecture->section_code }}

                        </div>

                    </div>

                </div>


                <div class="actions">


                    @if($lecture->status === 'not_started')

                        <button
                            type="button"
                            class="start-btn"
                            onclick="updateStatus(
                                {{ $lecture->schedule_id }},
                                'in_progress'
                            )"
                        >

                            Start Lecture

                        </button>

                    @endif


                    @if($lecture->status === 'in_progress')

                        <button
                            type="button"
                            class="finish-btn"
                            onclick="updateStatus(
                                {{ $lecture->schedule_id }},
                                'finished'
                            )"
                        >

                            Finish Lecture

                        </button>

                    @endif


                    @if(
                        $lecture->status !== 'finished' &&
                        $lecture->status !== 'cancelled'
                    )

                        <button
                            type="button"
                            class="cancel-btn"
                            onclick="updateStatus(
                                {{ $lecture->schedule_id }},
                                'cancelled'
                            )"
                        >

                            Cancel

                        </button>

                    @endif


                    <a
                        href="{{ route(
                            'teacher.lectures.attendance',
                            $lecture->schedule_id
                        ) }}"
                        class="attendance-btn"
                    >

                        Attendance

                    </a>

                </div>

            </div>

        @empty

            <div class="empty">

                No lectures found for today.

            </div>

        @endforelse

    </div>

</div>


<script>

async function updateStatus(
    scheduleId,
    status
) {

    if (
        !confirm(
            `Change lecture status to "${status}"?`
        )
    ) {
        return;
    }


    try {

        const response =
            await fetch(
                `/trainer/lectures/${scheduleId}/status`,
                {

                    method: 'PATCH',

                    headers: {

                        'Content-Type':
                            'application/json',

                        'Accept':
                            'application/json',

                        'X-CSRF-TOKEN':
                            document
                                .querySelector(
                                    'meta[name="csrf-token"]'
                                )
                                .getAttribute('content'),

                        'X-Requested-With':
                            'XMLHttpRequest'
                    },

                    body:
                        JSON.stringify({
                            status: status
                        })
                }
            );


        const data =
            await response.json();


        if (!response.ok) {

            throw new Error(
                data.message ||
                'Unable to update lecture status.'
            );
        }


        /*
         * كما طلبت:
         * لا Pusher.
         *
         * بمجرد تعديل الحالة:
         * Refresh.
         */

        window.location.reload();


    } catch (error) {

        console.error(error);

        alert(
            error.message
        );
    }
}

</script>

</body>

</html>