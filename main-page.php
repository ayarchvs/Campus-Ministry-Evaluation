<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?php
    include "modules/navigation-panel.php"
    ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Dashboard</h1>
                <ol class="breadcrumb mb-4">
                    <!-- <li class="breadcrumb-item active">Events Added</li> -->
                </ol>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        List
                    </div>

                    <?php
                    include("config/config.php");
                    include("access_control.php");

                    // Check if user is logged in
                    if (!isset($_SESSION['Staff_ID'])) {
                        header("Location: login.php");
                        exit;
                    }

                    // Fetch events based on user role
                    $allowed_event_types = get_allowed_event_types();
                    $event_type_placeholders = implode(',', array_fill(0, count($allowed_event_types), '?'));

                    $query = "SELECT event.*, staff.S_Name AS Staff_Name FROM `event`
                                    JOIN `staff` ON event.Staff_ID = staff.Staff_ID
                                    WHERE event.E_Type IN ($event_type_placeholders)";

                    $stmt = $conn->prepare($query);
                    $stmt->bind_param(str_repeat('s', count($allowed_event_types)), ...$allowed_event_types);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    ?>

                    <div class="card-body">
                        <table id="datatablesSimple1">
                            <thead>

                                <th>Event Date (YYYY/MM/DD)</th>
                                <th>Event Type</th>
                                <th>Event Course</th>
                                <th>Religion</th>
                                <th>Venue</th>
                                <th>Created By</th>
                                <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Event Date (YYYY/MM/DD)</th>
                                    <th>Event Type</th>
                                    <th>Event Course</th>
                                    <th>Religion</th>
                                    <th>Venue</th>
                                    <th>Created By</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['E_Year'] . '/' . $row['E_Month'] . '/' . $row['E_Day']) ?></td>
                                        <td><?= htmlspecialchars($row['E_Type']) ?></td>
                                        <td><?= htmlspecialchars($row['E_Course']) ?></td>
                                        <td><?= htmlspecialchars($row['E_Religion']) ?></td>
                                        <td><?= htmlspecialchars($row['E_Location']) ?></td>
                                        <td><?= htmlspecialchars($row['Staff_Name']) ?></td>
                                        <td>
                                            <button class="btn btn-primary view-btn" data-id="<?= $row['Event_ID'] ?>">View</button>
                                            <?php if (can_manage_event($row['E_Type'])): ?>
                                                <button class="btn btn-warning event-update-btn" data-id="<?= $row['Event_ID'] ?>">Update</button>
                                                <button class="btn btn-danger delete-btn" data-id="<?= $row['Event_ID'] ?>">Delete</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div class="modal fade" id="updateEventModal" tabindex="-1" aria-labelledby="updateEventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateEventModalLabel">Update Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="updateEventForm">
                        <input type="hidden" id="updateEventId" name="eventId">

                        <!-- Date -->
                        <div class="row mb-3">
                            <!-- Month Field -->
                            <div class="col-md-4">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="updateEventMonth" name="eventMonth" type="number" placeholder="Day" min="1" max="12" required />
                                    <label for="updateEventMonth">Month</label>
                                </div>
                            </div>

                            <!-- Day Field -->
                            <div class="col-md-4">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="updateEventDay" name="eventDay" type="number" placeholder="Day" min="1" max="31" required />
                                    <label for="updateEventDay">Day</label>
                                </div>
                            </div>

                            <!-- Year Field -->
                            <div class="col-md-4">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="updateEventYear" name="eventYear" type="number" placeholder="Enter year" min="1900" max="2100" required />
                                    <label for="updateEventYear">Year</label>
                                </div>
                            </div>
                        </div>


                        <!-- Event Type -->
                        <div class="form-floating mb-3">
                            <select class="form-control" id="updateEventType" name="eventType" aria-label="Event Type" required>
                                <option value="" disabled selected>Select</option>
                                <option value="Retreat">Retreat</option>
                                <option value="Recollection 02">Recollection 02</option>
                                <option value="Recollection 01">Recollection 01</option>
                            </select>
                            <label for="updateEventType">Event Type</label>
                        </div>

                        <!-- Religion -->
                        <div class="form-floating mb-3">
                            <select class="form-control" id="updateEventReligion" name="religion" aria-label="Religion" required>
                                <option value="" disabled selected>Select</option>
                                <option value="Christian">Christian</option>
                                <option value="Muslim">Muslim</option>
                                <option value="Non-Christian">Christians of Other Denominations</option>
                            </select>
                            <label for="updateEventReligion">Religion</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="updateEventCourse" name="course" placeholder="Course" required />
                            <label for="updateEventCourse">Course</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="updateEventLocation" name="location" placeholder="Location" required />
                            <label for="updateEventLocation">Location</label>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Event</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js">
        // needed for the options dropdown // need dl local 
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js">
        // needed for the options dropdown // need dl local 
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js">
        // needed for the options dropdown // need dl local
    </script>

    <script src="js/options-event.js"> </script>
    <script src="js/staff-options.js"></script>
</body>

</html>