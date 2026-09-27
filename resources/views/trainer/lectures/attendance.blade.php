<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Lecture Attendance</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;

            font-family: Arial, sans-serif;

            background: #f5f6f8;

            color: #172b4d;
        }

        .container {
            width: 95%;
            max-width: 1200px;

            margin: 40px auto;
        }

        .header {
            background: #ffffff;

            padding: 25px;

            border-radius: 12px;

            margin-bottom: 20px;

            box-shadow: 0 2px 10px rgba(0, 0, 0, .06);
        }

        .header-top {
            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 20px;
        }

        .header h1 {
            margin: 0 0 10px 0;

            font-size: 25px;
        }

        .header p {
            margin: 5px 0;

            color: #667085;
        }

        .back-btn {
            display: inline-block;

            padding: 10px 18px;

            background: #344054;

            color: #ffffff;

            text-decoration: none;

            border-radius: 7px;

            font-size: 14px;
        }

        .back-btn:hover {
            background: #1d2939;
        }


        /* =========================
           Statistics
        ========================= */

        .statistics {
            display: grid;

            grid-template-columns: repeat(4, 1fr);

            gap: 15px;

            margin-bottom: 20px;
        }

        .stat-card {
            background: #ffffff;

            padding: 20px;

            border-radius: 10px;

            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);

            text-align: center;
        }

        .stat-number {
            display: block;

            font-size: 28px;

            font-weight: bold;

            margin-bottom: 5px;
        }

        .stat-label {
            color: #667085;

            font-size: 14px;
        }

        .present {
            color: #198754;
        }

        .absent {
            color: #dc3545;
        }

        .late {
            color: #f79009;
        }

        .excused {
            color: #6941c6;
        }


        /* =========================
           Students Table
        ========================= */

        .students-card {
            background: #ffffff;

            border-radius: 12px;

            overflow: hidden;

            box-shadow: 0 2px 10px rgba(0, 0, 0, .06);
        }

        .students-header {
            padding: 20px;

            border-bottom: 1px solid #eaecf0;

            display: flex;

            justify-content: space-between;

            align-items: center;
        }

        .students-header h2 {
            margin: 0;

            font-size: 20px;
        }

        table {
            width: 100%;

            border-collapse: collapse;
        }

        thead {
            background: #f9fafb;
        }

        th {
            text-align: left;

            padding: 15px;

            font-size: 13px;

            color: #667085;

            border-bottom: 1px solid #eaecf0;
        }

        td {
            padding: 15px;

            border-bottom: 1px solid #eaecf0;

            vertical-align: middle;
        }

        tbody tr:hover {
            background: #fafafa;
        }

        .student-name {
            font-weight: 600;

            color: #172b4d;
        }

        .academic-number {
            color: #667085;

            font-size: 14px;
        }


        /* =========================
           Status
        ========================= */

        .status-select {
            min-width: 150px;

            padding: 9px 12px;

            border: 1px solid #d0d5dd;

            border-radius: 7px;

            background: #ffffff;

            font-size: 14px;

            cursor: pointer;
        }

        .status-select:focus {
            outline: none;

            border-color: #667085;
        }


        /* =========================
           Save Button
        ========================= */

        .save-btn {
            border: none;

            padding: 9px 16px;

            border-radius: 7px;

            background: #344054;

            color: #ffffff;

            cursor: pointer;

            font-size: 14px;
        }

        .save-btn:hover {
            background: #1d2939;
        }

        .save-btn:disabled {
            opacity: .6;

            cursor: not-allowed;
        }


        /* =========================
           Message
        ========================= */

        .message {
            position: fixed;

            top: 20px;

            right: 20px;

            padding: 14px 20px;

            border-radius: 8px;

            color: white;

            display: none;

            z-index: 9999;
        }

        .message.success {
            background: #198754;
        }

        .message.error {
            background: #dc3545;
        }


        /* =========================
           Empty
        ========================= */

        .empty {
            padding: 50px;

            text-align: center;

            color: #667085;
        }


        /* =========================
           Responsive
        ========================= */

        @media (max-width: 768px) {

            .statistics {
                grid-template-columns: repeat(2, 1fr);
            }

            .header-top {
                flex-direction: column;

                align-items: flex-start;
            }

            .students-card {
                overflow-x: auto;
            }

            table {
                min-width: 800px;
            }
        }

    </style>

</head>

<body>

<div class="container">


    {{-- =========================
         Header
    ========================== --}}

    <div class="header">

        <div class="header-top">

            <div>

                <h1>
                    Lecture Attendance
                </h1>

                <p>
                    Schedule ID:
                    <strong>
                        {{ $scheduleId }}
                    </strong>
                </p>

                @if(isset($lecture->date))
                    <p>
                        Date:
                        <strong>
                            {{ $lecture->date }}
                        </strong>
                    </p>
                @endif

                @if(isset($lecture->start_time) && isset($lecture->end_time))

                    <p>
                        Time:
                        <strong>
                            {{ $lecture->start_time }}
                            -
                            {{ $lecture->end_time }}
                        </strong>
                    </p>

                @endif

                @if(isset($lecture->section_code))

                    <p>
                        Section:
                        <strong>
                            {{ $lecture->section_code }}
                        </strong>

                        @if(isset($lecture->section_name))
                            - {{ $lecture->section_name }}
                        @endif
                    </p>

                @endif

            </div>


            <a
                href="{{ route('teacher.lectures') }}"
                class="back-btn"
            >
                ← Back to Lectures
            </a>

        </div>

    </div>


    {{-- =========================
         Statistics
    ========================== --}}

    <div class="statistics">

        <div class="stat-card">

            <span
                class="stat-number"
                id="present-count"
            >
                0
            </span>

            <span class="stat-label">
                Present
            </span>

        </div>


        <div class="stat-card">

            <span
                class="stat-number"
                id="absent-count"
            >
                0
            </span>

            <span class="stat-label">
                Absent
            </span>

        </div>


        <div class="stat-card">

            <span
                class="stat-number"
                id="late-count"
            >
                0
            </span>

            <span class="stat-label">
                Late
            </span>

        </div>


        <div class="stat-card">

            <span
                class="stat-number"
                id="excused-count"
            >
                0
            </span>

            <span class="stat-label">
                Excused
            </span>

        </div>

    </div>


    {{-- =========================
         Students
    ========================== --}}

    <div class="students-card">

        <div class="students-header">

            <h2>
                Students
            </h2>

            <span>
                {{ count($attendance) }} Students
            </span>

        </div>


        @if(count($attendance) > 0)

            <table>

                <thead>

                <tr>

                    <th>
                        #
                    </th>

                    <th>
                        Student
                    </th>

                    <th>
                        Academic Number
                    </th>

                    <th>
                        Section
                    </th>

                    <th>
                        Attendance
                    </th>

                    <th>
                        Action
                    </th>

                </tr>

                </thead>


                <tbody>

                @foreach($attendance as $index => $student)

                    <tr
                        data-student-id="{{ $student->trainee_id }}"
                    >

                        <td>
                            {{ $index + 1 }}
                        </td>


                        <td>

                            <div class="student-name">

                                {{ $student->trainee_name }}

                            </div>

                        </td>


                        <td>

                            <div class="academic-number">

                                {{ $student->academic_number }}

                            </div>

                        </td>


                        <td>

                            {{ $student->section_code ?? '-' }}

                        </td>


                        <td>

                            <select
                                class="status-select"
                                data-trainee-id="{{ $student->trainee_id }}"
                            >

                                <option
                                    value=""
                                    {{ empty($student->attendance_status) ? 'selected' : '' }}
                                >
                                    Not Marked
                                </option>

                                <option
                                    value="present"
                                    {{ $student->attendance_status === 'present' ? 'selected' : '' }}
                                >
                                    Present
                                </option>

                                <option
                                    value="absent"
                                    {{ $student->attendance_status === 'absent' ? 'selected' : '' }}
                                >
                                    Absent
                                </option>

                                <option
                                    value="late"
                                    {{ $student->attendance_status === 'late' ? 'selected' : '' }}
                                >
                                    Late
                                </option>

                                <option
                                    value="excused"
                                    {{ $student->attendance_status === 'excused' ? 'selected' : '' }}
                                >
                                    Excused
                                </option>

                            </select>

                        </td>


                        <td>

                            <button
                                type="button"
                                class="save-btn"
                                onclick="saveAttendance(
                                    {{ $student->trainee_id }},
                                    this
                                )"
                            >
                                Save
                            </button>

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        @else

            <div class="empty">

                No students found for this lecture.

            </div>

        @endif

    </div>

</div>


{{-- =========================
     Message
========================== --}}

<div
    id="message"
    class="message"
></div>


<script>

    /*
    |--------------------------------------------------------------------------
    | CSRF Token
    |--------------------------------------------------------------------------
    */

    const csrfToken =
        document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute('content');


    /*
    |--------------------------------------------------------------------------
    | Schedule ID
    |--------------------------------------------------------------------------
    */

    const scheduleId =
        @json($scheduleId);


    /*
    |--------------------------------------------------------------------------
    | Save Attendance
    |--------------------------------------------------------------------------
    */

    async function saveAttendance(traineeId, button)
    {
        const row =
            document.querySelector(
                `tr[data-student-id="${traineeId}"]`
            );

        if (!row) {
            return;
        }


        const select =
            row.querySelector('.status-select');


        const status =
            select.value;


        if (!status) {

            showMessage(
                'Please select attendance status.',
                'error'
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Disable Button
        |--------------------------------------------------------------------------
        */

        button.disabled = true;

        button.innerText = 'Saving...';


        try {

            const url =
                `/teacher/lectures/${scheduleId}/attendance/${traineeId}`;


            const response =
                await fetch(url, {

                    method: 'PATCH',

                    headers: {

                        'Content-Type':
                            'application/json',

                        'Accept':
                            'application/json',

                        'X-CSRF-TOKEN':
                            csrfToken,

                        'X-Requested-With':
                            'XMLHttpRequest'

                    },

                    body: JSON.stringify({

                        status: status

                    })

                });


            const data =
                await response.json();


            if (!response.ok) {

                throw new Error(
                    data.message ||
                    'Failed to update attendance.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Success
            |--------------------------------------------------------------------------
            */

            showMessage(
                'Attendance saved successfully.',
                'success'
            );


            /*
            |--------------------------------------------------------------------------
            | Update Statistics
            |--------------------------------------------------------------------------
            */

            updateStatistics();

        } catch (error) {

            console.error(error);

            showMessage(
                error.message ||
                'Something went wrong.',
                'error'
            );

        } finally {

            button.disabled = false;

            button.innerText = 'Save';

        }
    }


    /*
    |--------------------------------------------------------------------------
    | Update Statistics
    |--------------------------------------------------------------------------
    */

    function updateStatistics()
    {
        let present = 0;
        let absent = 0;
        let late = 0;
        let excused = 0;


        document
            .querySelectorAll('.status-select')
            .forEach(select => {

                switch (select.value) {

                    case 'present':
                        present++;
                        break;

                    case 'absent':
                        absent++;
                        break;

                    case 'late':
                        late++;
                        break;

                    case 'excused':
                        excused++;
                        break;

                }

            });


        document.getElementById('present-count')
            .innerText = present;

        document.getElementById('absent-count')
            .innerText = absent;

        document.getElementById('late-count')
            .innerText = late;

        document.getElementById('excused-count')
            .innerText = excused;
    }


    /*
    |--------------------------------------------------------------------------
    | Message
    |--------------------------------------------------------------------------
    */

    function showMessage(message, type)
    {
        const element =
            document.getElementById('message');


        element.innerText = message;

        element.className =
            `message ${type}`;

        element.style.display = 'block';


        setTimeout(() => {

            element.style.display = 'none';

        }, 2500);
    }


    /*
    |--------------------------------------------------------------------------
    | Initial Statistics
    |--------------------------------------------------------------------------
    */

    updateStatistics();

</script>

</body>

</html> 