<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalendarz</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css">

    <style>
        :root {
            --bs-success-rgb: 71, 222, 152 !important;
        }

        html,
        body {
            height: 100%;
            width: 100%;
            font-family: Apple Chancery, cursive;
        }

        .btn-info.text-light:hover,
        .btn-info.text-light:focus {
            background: #000;
        }
        table, tbody, td, tfoot, th, thead, tr {
            border-color: #ededed !important;
            border-style: solid;
            border-width: 1px !important;
        }
        .title{
            font-size: 30px;
        }
    </style>
</head>
<body class="bg-light">

<?php
require_once('../connect.php');

$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);

if($polaczenie->connect_errno!=0)
{
    echo "Error: ".$polaczenie->connect_errno/*." Opis: ".$polaczenie->connect_error*/;
}
else
{
    $schedules = $polaczenie->query("SELECT * FROM `calendar`");
    $sched_res = [];

    foreach($schedules->fetch_all(MYSQLI_ASSOC) as $row){
        $row['sdate'] = date("F d, Y h:i A",strtotime($row['start_date']));
        $row['edate'] = date("F d, Y h:i A",strtotime($row['end_date']));
        $sched_res[$row['id']] = $row;
    }
}
if(isset($polaczenie)) $polaczenie->close();
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark bg-gradient" id="topNavBar">
    <div class="container d-flex justify-content-center">
        <div class="row">
            <div class="col-md-12">
                <a class="navbar-brand title" href="#">Witamy w kalendarzu</a>
            </div>
        </div>
    </div>
</nav>
<div class="container py-5" id="page-container">
    <div class="row">
        <div class="col-md-9">
            <div id="calendar"></div>
        </div>
        <div class="col-md-3">
            <div class="cardt rounded-0 shadow">
                <div class="card-header bg-gradient bg-primary text-light">
                    <h5 class="card-title">Dodaj wydarzenie</h5>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <form action="save_calendar.php" method="post" id="schedule-form">
                            <input type="hidden" name="id" value="">
                            <div class="form-group mb-2">
                                <label for="title" class="control-label">Tytuł</label>
                                <input type="text" class="form-control form-control-sm rounded-0" name="title" id="title" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="description" class="control-label">Opis</label>
                                <textarea rows="3" class="form-control form-control-sm rounded-0" name="description" id="description"></textarea>
                            </div>
                            <div class="form-group mb-2">
                                <label for="start_date" class="control-label">Początek</label>
                                <input type="datetime-local" class="form-control form-control-sm rounded-0" name="start_date" id="start_date" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="end_date" class="control-label">Koniec</label>
                                <input type="datetime-local" class="form-control form-control-sm rounded-0" name="end_date" id="end_date" required>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-center">
                        <button class="btn btn-primary btn-sm rounded-0" type="submit" form="schedule-form"><i class="fa fa-save"></i> Zapisz</button>
                        <button class="btn btn-default border btn-sm rounded-0" type="reset" form="schedule-form"><i class="fa fa-reset"></i> Anuluj</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h1><a style="padding-left: 5%" href="../../php/main_page.php">powrót do strony domowej</a></h1>
</div>
<!-- Event Details Modal -->
<div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-0">
            <div class="modal-header rounded-0">
                <h5 class="modal-title">Szczegóły wydarzenia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body rounded-0">
                <div class="container-fluid">
                    <dl>
                        <dt class="text-muted">Tytuł</dt>
                        <dd id="title" class="fw-bold fs-4"></dd>
                        <dt class="text-muted">Opis</dt>
                        <dd id="description" class=""></dd>
                        <dt class="text-muted">Początek</dt>
                        <dd id="start" class=""></dd>
                        <dt class="text-muted">Koniec</dt>
                        <dd id="end" class=""></dd>
                    </dl>
                </div>
            </div>
            <div class="modal-footer rounded-0">
                <div class="text-end">
                    <button type="button" class="btn btn-primary btn-sm rounded-0" id="edit" data-id="">Edytuj</button>
                    <button type="button" class="btn btn-danger btn-sm rounded-0" id="delete" data-id="">Usuń</button>
                    <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Zamknij</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
<script src="../../scripts/calendar.js"></script>
<script>
    var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
</script>
</body>
</html>