<?php
global $mysqli;
session_start();

$timeout_duration = 5 * 60; // 5 minutes

if (isset($_SESSION["admin"])) {
    if (isset($_SESSION['lastActivity'])) {
        if (time() - $_SESSION['lastActivity'] > $timeout_duration) {
            // Session has timed out, logout
            echo '<script>
            alert("Session timed out. Redirecting to login.");
            window.location.href="../include/logout.php";
            </script>';
        }
    }
    $_SESSION['lastActivity'] = time();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="../res/css/adminStyle.css">
    <link rel="stylesheet" href="../res/css/datePicker.css">
    <link href="../assets/img/favicon.png" rel="icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet" />

    <!-- jQuery (Single inclusion) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Moment.js and DateRangePicker -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- Additional JS Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>

    <!-- Custom Scripts -->
    <script src="../res/js/admin/javascript.js"></script>
</head>


<body>
    <header>
        <div class="logo">
            <img src="../assets/img/logo.png" alt="Saint Louis University Logo"
                style="width: 150px; height: auto; margin-left: 40px;">
            <h3 class="dashboardTitle" style="margin-left: 30px;"> Admin Dashboard</h3>
        </div>
        <div class="greetings" style="display: flex; align-items: center; margin-left:-30px">

            <img src="../res/images/user-image.png" alt="User Icon" aria-hidden="true">
            <div class="greeting" style="margin-right: 10px;">
                <div id="admin-name" class="curator"></div>
                <nav>
                    <a href="../include/logout.php" aria-label="Logout">Logout</a>
                </nav>
            </div>
        </div>
    </header>

    <div class="main-container">
        <div class="left-container">
            <div class="analytics">
                <h1>Visitor Analytics</h1>
                <h3>Visitor by School</h3>
                <canvas id="donutChart" width="1000" height="300"></canvas>
                <h3>Visitor Log Book</h3>
                <div>
                    <label for="startDate">Start Date:</label>
                    <input type="date" id="startDate">
                    <label for="endDate">End Date:</label>
                    <input type="date" id="endDate">
                    <button id="applyFilter">Apply Filter</button>
                    <button id="resetFilter">Reset</button>
                </div>
                <div id="userTableContainer">
                    <table id="visitorAnalyticsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>School</th>
                                <th>Date of Visit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dynamically populated rows -->
                        </tbody>
                    </table>
                </div>
                <div>
                    <button id="printTable">Print Table</button>
                </div>
                <br>
                <div class="feedbackSection">
                    <br>
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">Visitor Feedback</div>
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="text-end">Date</th>
                                        <th scope="col" class="text-end">Quality/Presentation of Exhibits</th>
                                        <th scope="col" class="text-end">Cleanliness and Ambiance</th>
                                        <th scope="col" class="text-end">Museum Staff Service</th>
                                        <th scope="col" class="text-end">Overall Experience</th>
                                        <th scope="col" class="text-end">Comments, Questions, or Suggestions</th>
                                    </tr>
                                </thead>
                                <tbody id="feedback-table-body">
                                    <!-- Feedback will be loaded here -->
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <!-- Feedback Summary Section -->
                        <div class="feedback-summary">
                            <div class="card-title">Feedback Summary</div>
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="text-end">Category</th>
                                        <th scope="col" class="text-end">Excellent</th>
                                        <th scope="col" class="text-end">Good</th>
                                        <th scope="col" class="text-end">Average</th>
                                        <th scope="col" class="text-end">Dissatisfied</th>
                                    </tr>
                                    </thead>
                                    <tbody id="feedback-summary-body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="right-container">
            <div class="artifacts">
                <h2>Artifacts</h2>
                <div class="tabs">
                    <div class="tab active" onclick="openTab('search')">
                        Search Artifact
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="tab" onclick="openTab('add')">Add Artifact
                        <img src="../assets/img/vase.png" alt="Vase Icon" class="icon">
                    </div>
                    <div class="tab" onclick="openTab('add2')">Add Artifact Group
                        <i class="fas fa-archive"></i>
                    </div>
                    <div class="tab active" onclick="openTab('edit-group')">
                        Edit Artifact Group
                        <i class="fas fa-edit"></i>
                    </div>
                </div>
                <div id="search" class="tab-content active" style="background-color: #ffffff;">
                    <div class="search-container">
                        <input type="text" class="search-input" placeholder="Search artifact..."
                            oninput="searchArtifact()">
                        <button class="search-button" onclick="searchArtifact()">Search</button>
                    </div>
                    <button id="toggle-multi-select" onclick="toggleMultiSelect()">Enable Multi-Select</button>
                    <button id="delete-selected-button" style="display: none;"
                        onclick="deleteSelectedArtifacts()">Delete Selected</button>
                    <div id="search-results"></div>
                </div>

                <div id="overlay-success"
                     style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0, 0, 0, 0.7); z-index:1000;">
                    <div
                            style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:20px; border-radius:5px; text-align:center;">
                        <p id="overlay-message-success"></p>
                        <button id="close-overlay-success">Okay</button>
                    </div>
                </div>

                <div id="overlay2"
                     style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0, 0, 0, 0.7); z-index:1000;">
                    <div
                            style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:20px; border-radius:5px; text-align:center;">
                        <p id="overlay-message2"></p>
                        <button id="close-overlay2">Okay</button>
                        <button onclick="closeOverlay2()">Cancel</button> <!-- Cancel button -->
                    </div>
                </div>

                <div id="overlay-success2"
                     style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0, 0, 0, 0.7); z-index:1000;">
                    <div
                            style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:20px; border-radius:5px; text-align:center;">
                        <p id="overlay-message-success2"></p>
                    </div>
                </div>

                <div id="overlay-delete-confirmation" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0, 0, 0, 0.7); z-index:1000;">
                    <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:20px; border-radius:5px; text-align:center;">
                        <p id="overlay-message-delete"></p>
                        <button id="confirm-delete">Confirm Delete</button>
                        <button id="cancel-delete">Cancel</button>
                    </div>
                </div>

                <div id="overlay-no-selection" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0, 0, 0, 0.7); z-index:1000;">
                    <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:20px; border-radius:5px; text-align:center;">
                        <p id="overlay-message-no-selection"></p>
                        <button id="close-overlay-no-selection">Okay</button>
                    </div>
                </div>

                <!-- Edit Popup Window -->
                <div id="edit-modal" class="modal">
                    <div class="modal-content">
                        <span class="close-button" onclick="closeModal()">&times;</span>
                        <h2>Edit Artifact</h2>
                        <form id="edit-form" action="../include/editArtifactMedia.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" id="artifact-id" name="artifact-id">
                            <label for="artifact-id">Artifact ID:</label>
                            <span id="artifact-id-display"></span>
                            <br>
                            <br>
                            <label for="editName">Name:</label>
                            <input type="text" id="editName" name="name">
                            <br>
                            <label for="editSection">Section:</label>
                            <select id="editSection" name="section" onchange="fetchCatalogs(this.value)"></select>
                            <br>
                            <label for="editCatalog">Catalogue:</label>
                            <select id="editCatalog" name="catalog"></select>
                            <br>
                            <label for="editSubcatalog">Subcatalogue:</label>
                            <select id="editSubcatalog" name="subcatalog"></select>
                            <br>
                            <label for="description">Description:</label>
                            <textarea id="editDescription" name="description"></textarea>
                            <br>
                            <label for="description">Virtual Avatar Script:</label>
                            <textarea id="editScript" name="script"></textarea>
                            <br>
                            <label for="artifact-media">Upload Video:</label>
                            <input type="file" id="artifact-media" name="artifact-media" accept="video/*">
                            <br>
                            <button type="submit">Upload</button>
                            <button id="saveBtn" type="button" onclick="saveChanges()">Save</button>
                            <button id="delBtn" type="button"
                                onclick="deleteArtifact(document.getElementById('artifact-id').value)">Delete</button>
                        </form>
                    </div>
                </div>

                <div id="add" class="tab-content" style="background-color: #ffffff; margin-top: -20px;">
                    <div class="form-container">
                        <form id="addArtifactForm" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="artifact-name">Artifact Name:</label>
                                <input type="text" id="artifact-name" name="artifact-name" required>
                            </div>
                            <div class="form-group">
                                <label for="section">Section:</label>
                                <select id="section" name="section" required></select>
                            </div>
                            <div class="form-group">
                                <label for="catalog">Catalog:</label>
                                <select id="catalog" name="catalog" required></select>
                            </div>
                            <div class="form-group">
                                <label for="sub-catalog">Sub Catalog:</label>
                                <select id="sub-catalog" name="sub-catalog" required></select>
                            </div>
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea id="description" name="description" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="condition">Condition:</label>
                                <textarea id="condition" name="condition" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="script">Virtual Avatar Script:</label>
                                <textarea id="script" name="script" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="media-upload">Upload Media:</label>
                                <input type="file" id="media-select" name="media-select" accept="video/*">
                            </div>
                            <button type="submit">Add Artifact</button>
                        </form>
                    </div>
                </div>

                <div id="overlay"
                    style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0, 0, 0, 0.7); z-index:1000;">
                    <div
                        style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:20px; border-radius:5px; text-align:center;">
                        <p id="overlay-message"></p>
                        <div id="qrcode" style="margin-top: 20px;"></div>
                        <button id="close-overlay">Okay</button>
                    </div>
                </div>

                <div id="add2" class="tab-content">
                    <div class="form-container">
                        <form id="category-form">
                            <h3 style="text-align: center;">Add New Section</h3>
                            <div class="form-group">
                                <label for="create-new-section">New Section Title:</label>
                                <input type="text" id="create-new-section" name="new_section">
                            </div>
                            <div class="button-container">
                                <button type="button" onclick="submitForm('create_section')" class="btn">Create Section</button>
                            </div>
                            <h1> </h1>
                            <hr>
                            <h3 style="text-align: center;">Add New Catalog</h3>
                            <div class="form-group">
                                <label for="create-select-section">Choose Section:</label>
                                <select id="create-select-section" name="section_id">
                                    <option value="">Select Section</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="create-new-catalog">New Catalog Name:</label>
                                <input type="text" id="create-new-catalog" name="new_catalog">
                            </div>
                            <div class="button-container">
                                <button type="button" onclick="submitForm('create_catalog')" class="btn">Create Catalog</button>
                            </div>
                            <h1> </h1>
                            <hr>
                            <h3 style="text-align: center;">Add New Subcatalog</h3>
                            <div class="form-group">
                                <label for="create-select-catalog">Choose Catalog:</label>
                                <select id="create-select-catalog" name="catalogue_id">
                                    <option value="">Select Catalog</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="create-new-subcatalog">New Subcatalog Name:</label>
                                <input type="text" id="create-new-subcatalog" name="new_subcatalog">
                            </div>
                            <div class="button-container">
                                <button type="button" onclick="submitForm('create_subcatalog')" class="btn">Create Subcatalog</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div id="messageOverlay" class="overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1000;">
                    <div class="overlay-content" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border-radius: 5px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                        <p id="overlayMessage"></p>
                        <button onclick="closeOverlay()" style="margin-top: 10px;">Okay</button>
                    </div>
                </div>

                <div id="edit-group" class="tab-content" style="background-color: #ffffff; margin-top: -20px;">
                    <div class="form-container">
                        <form action="" method="post">
                            <h3 style="text-align: center;">Edit Section</h3>
                            <div class="form-group">
                                <label for="edit-select-section">Section:</label>
                                <select id="edit-select-section" name="section_id">
                                    <option value="">Select Section</option>
                                </select>
                            </div>
                            <div class="edit-delete-button-container" id="button-container-section">
                                <button type="button" class="btn" onclick="openEditSectionModal()">Edit Section</button>
                                <button type="button" id="delBtn" class="btn" onclick="deleteSection()">Delete Section</button>
                            </div>
                            <h1> </h1>
                            <hr>
                            <h3 style="text-align: center;">Edit Catalog</h3>
                            <div class="form-group">
                                <label for="edit-select-catalog">Catalog:</label>
                                <select id="edit-select-catalog" name="section_id">
                                    <option value="">Select Catalog</option>
                                </select>
                            </div>
                            <div class="edit-delete-button-container" id="button-container-catalog">
                                <button type="button" name="action" value="edit_catalog" class="btn" onclick="openEditCatalogModal()">Edit Catalog</button>
                                <button type="button" id="delBtn" class="btn" onclick="deleteCatalog()">Delete Catalog</button>
                            </div>
                            <h1> </h1>
                            <hr>
                            <h3 style="text-align: center;">Edit Subcatalog</h3>
                            <div class="form-group">
                                <label for="edit-select-subcatalog">Subcatalog:</label>
                                <select id="edit-select-subcatalog" name="catalogue_id">
                                    <option value="">Select Subcatalog</option>
                                </select>
                            </div>
                            <div class="edit-delete-button-container" id="button-container-subcatalog">
                                <button type="button" name="action" value="create_subcatalog" onclick="openEditSubcatalogModal()" class="btn">Edit Subcatalog</button>
                                <button type="button" id="delBtn" class="btn" onclick="deleteSubcat()">Delete Subcatalog</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Edit Section Popup Window -->
                <div id="edit-section-modal" class="modal" style="display: none;">
                    <div class="modal-content">
                        <span class="close-button" onclick="closeSectionModal()">&times;</span>
                        <h2>Edit Section</h2>
                        <form id="edit-section-form" action=" " method="POST">
                            <input type="hidden" id="section-id" name="section-id">

                            <!-- Display Section ID -->
                            <label for="section-id">Section ID:</label>
                            <span id="section-id-display"></span>
                            <br>

                            <!-- Display Section Name -->
                            <label for="section-id">Section Name:</label>
                            <span id="section-name-display"></span>
                            <br>

                            <!-- New Section Name -->
                            <label for="editSectionName">New Section Name:</label>
                            <input type="text" id="editSectionName" name="section-name">
                            <br>

                            <!-- Save Button -->
                            <button id="saveSectionBtn" type="button" onclick="saveSectionChanges()">Save</button>
                        </form>
                    </div>
                </div>

                <!-- Edit Catalog Popup Window -->
                <div id="edit-catalog-modal" class="modal" style="display: none;">
                    <div class="modal-content">
                        <span class="close-button" onclick="closeCatalogModal()">&times;</span>
                        <h2>Edit Catalog</h2>
                        <form id="edit-catalog-form" action=" " method="POST">
                            <input type="hidden" id="catalog-id" name="catalog-id">

                            <!-- Display Catalog ID -->
                            <label for="catalog-id">Catalog ID:</label>
                            <span id="catalog-id-display"></span>
                            <br>

                            <!-- Display Catalog Name -->
                            <label for="catalog-name">Catalog Name:</label>
                            <span id="catalog-name-display"></span>
                            <br>

                            <!-- Catalog Name -->
                            <label for="editCatalogName">New Catalog Name:</label>
                            <input type="text" id="editCatalogName" name="catalog-name" required>
                            <br>

                            <!-- Save Button -->
                            <button id="saveCatalogBtn" type="button" onclick="saveCatalogChanges()">Save</button>
                        </form>
                    </div>
                </div>

                <!-- Edit Subcatalog Popup Window -->
                <div id="edit-subcatalog-modal" class="modal" style="display: none;">
                    <div class="modal-content">
                        <span class="close-button" onclick="closeSubcatalogModal()">&times;</span>
                        <h2>Edit Subcatalog</h2>
                        <form id="edit-subcatalog-form" action=" " method="POST">
                            <input type="hidden" id="subcatalog-id" name="subcatalog-id">

                            <!-- Display Subcatalog ID -->
                            <label for="subcatalog-id">Subcatalog ID:</label>
                            <span id="subcatalog-id-display"></span>
                            <br>

                            <!-- Display Subcatalog Name -->
                            <label for="subcatalog-name">Subcatalog Name:</label>
                            <span id="subcatalog-name-display"></span>
                            <br>

                            <!-- Subcatalog Name -->
                            <label for="editSubcatalogName">New Subcatalog Name:</label>
                            <input type="text" id="editSubcatalogName" name="subcatalog-name" required>
                            <br>

                            <!-- Save Button -->
                            <button id="saveSubcatalogBtn" type="button" onclick="saveSubcatalogChanges()">Save</button>
                        </form>
                    </div>
                </div>

                <div class="cordi-media">
                    <!-- Start of Cordilleran Performing Arts Media div -->
                    <h2>Cordilleran Performing Arts Media</h2>
                    <div class="tabs">
                        <div class="tab active" onclick="openTab('upload')">
                            Upload Media
                            <i class="fas fa-upload"></i>
                        </div>
                        <div class="tab" onclick="openTab('edit')">
                            Edit Media
                            <i class="fas fa-edit"></i>
                        </div>
                    </div>
                    <div id="upload" class="tab-content active" style="background-color: #ffffff; margin-top: -20px;">
                        <h3>Upload Media</h3>
                        <form id="upload-form" action="../include/uploadMedia.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="media-title">Media Title:</label>
                                <input type="text" id="media-title" name="media-title" required>
                            </div>
                            <div class="form-group">
                                <label for="media-description">Media Description:</label>
                                <textarea id="media-description" name="media-description" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="media-file">Select Media File:</label>
                                <input type="file" id="media-file" name="media-file" accept="video/*" required>
                            </div>
                            <button type="submit" id="general-media-upload-btn" onCLick="disableButton()">Upload</button>
                        </form>
                        <script>
                        function disableButton() {
                            document.getElementById("general-media-upload-btn").disabled = true;
                            document.getElementById("upload-form").submit();
                        }
                        </script>
                    </div>
                    <div id="edit" class="tab-content" style="background-color: #ffffff; margin-top: -20px;">
                        <h3>Edit Artifact Media</h3>
                        <form id="media-form">
                            <button type="button" id="select-media-button">
                                Select Media
                            </button>
                            <p id="selected-media-id" style="padding-left: 10px; font-weight: bold; font-size: 18px;">
                            </p>
                            <div class="form-group" id="new-title-field" style="display: none">
                                <label for="new-media-title">New Media Title:</label>
                                <input type="text" id="new-media-title" name="new-media-title" required>
                            </div>
                            <div class="form-group" id="new-desc-field" style="display: none">
                                <label for="new-media-description">New Media Description:</label>
                                <textarea id="new-media-description" name="new-media-description" required></textarea>
                            </div>
                            <button type="submit" onclick="updateMedia()" id="update-media-btn"
                                style="display: none">Update Media</button>
                        </form>
                    </div>
                </div> <!-- End of Cordilleran Performing Arts Media div -->
            </div> <!-- End of artifacts div -->
        </div> <!-- End of right-container div -->

        <div class="edit-media-popup" id="edit-media-popup">
            <div class="content">
                <img src="/res/images/exit-icon.png" alt="Close" class="close-edit">
                <div class="media-display">
                    <ul>
                        <?php
                            include '../include/artifact-db.php';

                            $result = $mysqli->query("SELECT * FROM uncategorized_media");

                            if ($result->num_rows > 0) {
                                // Output the data of each row in boxes
                                while ($row = $result->fetch_assoc()) {
                                    echo '<li>';
                                    // Wrap video and description in a div container for side-by-side layout
                                    echo '<div style="display: flex; align-items: center; justify-content: space-between;">';
                                    // Displaying the video
                                    $videoPath = '../assets/videos/general/' . $row["fileName"];
                                    if (file_exists($videoPath)) {
                                        // Displaying the video
                                        echo '<video width="240" height="180" controls style="margin-right: 20px;">';
                                        echo '<source src="' . $videoPath . '" type="video/mp4">';
                                        echo '</video>';
                                    } else {
                                        // Displaying a message if the video file is not found
                                        echo '<p style="font-weight: bold; color: red; font-size: 20px;">File Missing</p>';
                                    }
                                    // Description container
                                    echo '<div id="' . $row["id"] . '">';
                                    echo '<p id="media-id">ID: ' . $row["id"] . '</p>';
                                    echo '<p id="media-title">Title: ' . html_entity_decode($row["title"]) . '</p>';
                                    echo '<p id="media-description">Description: ' . html_entity_decode($row["description"]) . '</p>';
                                    echo '<p id="media-file-name">File Name: ' . html_entity_decode($row["fileName"]) . '</p>';
                                    echo '</div>';

                                    // Edit and Delete buttons
                                    echo '<div style="margin-left: 10px;">';
                                    echo '<button id="saveBtn" onclick="selectMedia(' . $row["id"] . ')">Edit</button> ';
                                    echo '<button id="delBtn" onclick="deleteMedia(' . $row["id"] . ')">Delete</button>';
                                    echo '</div>'; // End of buttons container
                                    echo '</li>'; // End of the list item
                                }
                            } else {
                                echo '0 results found';
                            }
                        
                            $mysqli->close();
                        ?>
                    </ul>
                </div>
            </div>
        </div>

        <script>
        document.getElementById("select-media-button").addEventListener("click", function() {
            document.querySelector(".edit-media-popup").style.display = "flex";
        })

        document.querySelector(".close-edit").addEventListener("click", function() {
            document.querySelector(".edit-media-popup").style.display = "none"
        })
        </script>


        <script src="/res/js/admin/admin.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- Include Chart.js library -->
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            const userTableContainer = document.getElementById("userTableContainer");
            const startDateInput = document.getElementById("startDate");
            const endDateInput = document.getElementById("endDate");
            const applyFilterButton = document.getElementById("applyFilter");
            const resetFilterButton = document.getElementById("resetFilter");
            const printTableButton = document.getElementById("printTable");


            let autoUpdateInterval = null; // To track the interval
            let appliedFilter = null; // To track the current filter

            // Function to format a date string in 'YYYY-MM-DD h:mm A' format
            function formatDate(dateStr) {
                const date = new Date(dateStr);
                const options = {
                    hour12: true,
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit'
                };
                return date.toLocaleString('en-US', options)
                    .replace(', ', ' ') // Replace the default comma after the date with a space
                    .replace(/:00$/, ''); // Remove seconds if not needed
            }


            // Function to fetch and display user data
            function fetchUserData(startDate = null, endDate = null) {
                const xhr = new XMLHttpRequest();
                let url = "../include/get-user.php";

                // Append date filters if provided
                if (startDate && endDate) {
                    url += `?startDate=${startDate}&endDate=${endDate}`;
                }

                xhr.open("GET", url, true);
                xhr.onload = function () {
                    if (this.status === 200) {
                        let response = this.responseText;
                        // Assuming the response contains HTML with date strings that need formatting
                        response = response.replace(/(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})/g, function(match) {
                            return formatDate(match);
                        });
                        userTableContainer.innerHTML = response;
                    } else {
                        userTableContainer.innerHTML = "<p>Error fetching data.</p>";
                    }
                };
                xhr.onerror = function () {
                    userTableContainer.innerHTML = "<p>Request failed.</p>";
                };
                xhr.send();
            }

            // Function to start automatic updates
            function startAutoUpdate() {
                if (!autoUpdateInterval) {
                    autoUpdateInterval = setInterval(() => fetchUserData(), 3000); // 3 seconds interval
                }
            }

            // Function to stop automatic updates
            function stopAutoUpdate() {
                if (autoUpdateInterval) {
                    clearInterval(autoUpdateInterval);
                    autoUpdateInterval = null;
                }
            }

            fetchUserData();

            // Event listener for applying the filter
            applyFilterButton.addEventListener("click", function () {
                const startDate = startDateInput.value;
                const endDate = endDateInput.value;

                if (startDate && endDate) {
                    stopAutoUpdate(); // Stop auto-update when a filter is applied
                    appliedFilter = { startDate, endDate }; // Set the applied filter
                    fetchUserData(startDate, endDate);
                } else {
                    alert("Please select both start and end dates.");
                }
            });

            // Event listener for resetting the filter
            resetFilterButton.addEventListener("click", function () {
                startDateInput.value = "";
                endDateInput.value = "";
                fetchUserData(); // Fetch all data
                startAutoUpdate(); // Resume auto-update after reset
            });

            // Event listener for printing the table
            printTableButton.addEventListener("click", function () {
                const tableContent = userTableContainer.innerHTML;
                const printWindow = window.open("", "", "width=800,height=600");
                printWindow.document.write("<html><head><title>Print Table</title></head><body>");

                if (appliedFilter) {
                    // Format the start and end dates for display
                    const formattedStartDate = new Date(appliedFilter.startDate).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: '2-digit'
                    });
                    const formattedEndDate = new Date(appliedFilter.endDate).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: '2-digit'
                    });

                    // Check if the start and end dates are the same
                    if (formattedStartDate === formattedEndDate) {
                        // Display just one date if they are the same
                        printWindow.document.write(
                            `<h1>Visitor Log</h1><p style="font-size: 14px; color: grey;">(${formattedStartDate})</p>`
                        );
                    } else {
                        // Display both dates if they are different
                        printWindow.document.write(
                            `<h1>Visitor Log</h1><p style="font-size: 14px; color: grey;">(${formattedStartDate} to ${formattedEndDate})</p>`
                        );
                    }
                } else {
                    // No filter selected, just display "Visitor Log"
                    printWindow.document.write("<h1>Visitor Log</h1>");
                }

                printWindow.document.write(tableContent);
                printWindow.document.write("</body></html>");
                printWindow.document.close();
                printWindow.print();
            });

            // Start automatic updates on page load
            startAutoUpdate();



            async function fetchChartData() {
                try {
                    const response = await fetch('../include/chart.php'); // Adjust the path
                    const data = await response.json();
                    if (!data.error) {
                        const total = data.counts.reduce((sum, count) => sum + count, 0);

                        // Add percentages to labels
                        const labelsWithPercentages = data.schools.map((school, index) => {
                            const count = data.counts[index];
                            const percentage = ((count / total) * 100).toFixed(2);
                            return `${school} (${percentage}%)`;
                        });

                        const ctx = document.getElementById('donutChart').getContext('2d');

                        if (window.donutChartInstance) {
                            window.donutChartInstance.destroy();
                        }

                        window.donutChartInstance = new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                labels: labelsWithPercentages, // Use labels with percentages
                                datasets: [{
                                    label: 'User Count by School',
                                    data: data.counts,
                                    backgroundColor: [
                                        "#ea5545", "#FFC400", "#F46A9B", "#FF1900", 
                                        "#ede15b", "#bdcf32", "#87bc45", "#27aeef", 
                                        "#656565", "#c94800", "#22beb6", "#727900"
                                    ],
                                    borderColor: 'white',
                                    borderWidth: 2,
                                    hoverOffset: 10
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                        align: 'start',
                                        labels: {
                                            font: {
                                                family: "Inter, serif",
                                                size: 12,
                                                weight: 'bold',
                                                color: '#333',
                                            },
                                            usePointStyle: true,
                                        },
                                    },
                                    title: {
                                        display: true,
                                        text: 'User Distribution by School',
                                        font: {
                                            family: "Inter, serif",
                                            size: 14,
                                            weight: 'bold',
                                            color: '#333',
                                        },
                                        padding: {
                                            top: 10,
                                            bottom: 20,
                                        },
                                    },
                                    tooltip: {

                                        titleFont: {
                                            family: "Inter, serif",
                                            size: 12,
                                            weight: 'bold',
                                            color: '#fff',
                                        },
                                        bodyFont: {
                                            family: "Inter, serif",
                                            size: 10,
                                            color: '#fff',
                                        },
                                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                                        borderColor: 'white',
                                        borderWidth: 1,
                                        padding: 10,
                                    },
                                }
                            }
                        });
                    } else {
                        console.error(data.error);
                    }
                } catch (error) {
                    console.error('Error fetching data:', error);
                }
            }

            function updateChartData() {
                fetchChartData();  // Update chart data
            }

            updateChartData();
            setInterval(updateChartData, 3600000); // 3600000ms = 1 hour for chart updates


            // Function to fetch section data for a dropdown
            function fetchSectionData() {
                fetch('../include/get.php') // Adjust the path if necessary
                    .then(response => response.json()).then(data => {
                        const sectionSelect = document.getElementById("create-select-section");
                        const sections = data.sections;
                        sections.forEach(section => {
                            if (section.section_name !== "N/A") {
                                const option = document.createElement("option");
                                option.value = section.section_id;
                                option.text = section.section_name;
                                sectionSelect.appendChild(option);
                            }
                        });
                    }).catch(error => {
                        console.error("Error fetching sections:", error);
                    });
            }
            // Function to fetch catalog data for a dropdown
            function fetchCatalogData() {
                fetch('../include/get.php') // Adjust the path if necessary
                    .then(response => response.json())
                    .then(data => {
                        const catalogSelect = document.getElementById("create-select-catalog");
                        const catalogues = data.catalogues;
                        catalogues.forEach(catalog => {
                            if (catalog.catalogue_name !== "N/A") { // Check if the catalogue name is not "N/A"
                                const option = document.createElement("option");
                                option.value = catalog.catalogue_id;
                                option.text = catalog.catalogue_name;
                                catalogSelect.appendChild(option);
                            }
                        });
                    })
                    .catch(error => {
                        console.error("Error fetching catalogues:", error);
                    });
            }

            function fetchEditSectionData() {
                fetch('../include/get.php') // Adjust the path if necessary
                    .then(response => response.json()).then(data => {
                        const sectionSelect = document.getElementById("edit-select-section");
                        const sections = data.sections;
                        sections.forEach(section => {
                            if (section.section_name !== "N/A") {
                                const option = document.createElement("option");
                                option.value = section.section_id;
                                option.text = section.section_name;
                                sectionSelect.appendChild(option);
                            }
                        });
                    }).catch(error => {
                        console.error("Error fetching sections:", error);
                    });
            }
            // Function to fetch catalog data for a dropdown
            function fetchEditCatalogData() {
                fetch('../include/get.php') // Adjust the path if necessary
                    .then(response => response.json())
                    .then(data => {
                        const catalogSelect = document.getElementById("edit-select-catalog");
                        const catalogues = data.catalogues;
                        catalogues.forEach(catalog => {
                            if (catalog.catalogue_name !== "N/A") { // Check if the catalogue name is not "N/A"
                                const option = document.createElement("option");
                                option.value = catalog.catalogue_id;
                                option.text = catalog.catalogue_name;
                                catalogSelect.appendChild(option);
                            }
                        });
                    })
                    .catch(error => {
                        console.error("Error fetching catalogues:", error);
                    });
            }

            // Function to fetch catalog data for a dropdown
            function fetchEditSubCatalogData() {
                fetch('../include/get.php') // Adjust the path if necessary
                    .then(response => response.json())
                    .then(data => {
                        const subcatalogSelect = document.getElementById("edit-select-subcatalog");
                        const subcatalogues = data.subcatalogues;
                        subcatalogues.forEach(subcatalog => {
                            if (subcatalog.subcat_name !== "N/A") { // Check if the catalogue name is not "N/A"
                                const option = document.createElement("option");
                                option.value = subcatalog.subcat_id;
                                option.text = subcatalog.subcat_name;
                                subcatalogSelect.appendChild(option);
                            }
                        });
                    })
                    .catch(error => {
                        console.error("Error fetching catalogues:", error);
                    });
            }


            // Consolidate DOMContentLoaded
            fetchSectionData(); // Fetch and populate sections in the dropdown
            fetchCatalogData(); // Fetch and populate catalogues in the dropdown
            fetchSectionData(); // Fetch and populate sections in the dropdown
            fetchEditSectionData();
            fetchEditCatalogData();
            fetchCatalogData(); // Fetch and populate catalogues in the dropdown
            fetchEditSubCatalogData();
            openEditSectionModal();
            closeSectionModal();
            openEditCatalogModal();
            closeCatalogModal();
            openEditSubcatalogModal();
            closeSubcatalogModal();
        });
        </script>
        <script type="text/javascript">
        $(function() {

            $('input[name="datefilter"]').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format(
                    'MM/DD/YYYY'));
            });

            $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

        });
        </script>

        <script>
        function toggleNotifications() {
            const popup = document.getElementById('notificationPopup');
            popup.style.display = popup.style.display === 'none' || popup.style.display === '' ? 'block' : 'none';
        }

        // Optional: Close the notification popup when clicking outside of it
        window.onclick = function(event) {
            const popup = document.getElementById('notificationPopup');
            if (!event.target.matches('.fas.fa-bell') && !popup.contains(event.target)) {
                popup.style.display = 'none';
            }
        }
        </script>
        <script>
            // Function to fetch feedback data
            function fetchFeedback() {
                fetch('../include/getFeedback.php')
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('feedback-table-body').innerHTML = data;
                    })
                    .catch(error => console.error('Error fetching feedback:', error));
            }

            // Function to fetch feedback summary data
            function fetchFeedbackSummary() {
                fetch('../include/getFeedbackSummary.php')
                    .then(response => response.json())
                    .then(data => {
                        let summaryHTML = '';
                        if (data.length === 1 && data[0].category === '') {
                            summaryHTML = data[0].excellent;
                        } else {
                            data.forEach(summary => {
                                summaryHTML += `
                        <tr>
                            <td class="text-end">${summary.category}</td>
                            <td class="text-end">${summary.excellent}</td>
                            <td class="text-end">${summary.good}</td>
                            <td class="text-end">${summary.average}</td>
                            <td class="text-end">${summary.dissatisfied}</td>
                        </tr>
                    `;
                            });
                        }
                        document.getElementById('feedback-summary-body').innerHTML = summaryHTML;
                    })
                    .catch(error => console.error('Error fetching feedback summary:', error));
            }

            document.addEventListener('DOMContentLoaded', function() {
                fetchFeedback();
                fetchFeedbackSummary();

                // Set interval to check for new feedback every 3 seconds
                setInterval(fetchFeedback, 3000); // 3000ms = 3 seconds
                setInterval(fetchFeedbackSummary, 3000); // 3000ms = 3 seconds

            });
        </script>
        <script>
        // Initially hide all buttons
        document.querySelectorAll(".edit-delete-button-container").forEach(function(container) {
            container.querySelectorAll(".btn").forEach(function(button) {
                button.style.display = 'none';
            });
        });
        
        // Function to toggle button visibility based on the selected value
        document.getElementById("edit-select-section").addEventListener("change", function() {
            toggleButtons("edit-select-section", "button-container-section");
        });

        document.getElementById("edit-select-catalog").addEventListener("change", function() {
            toggleButtons("edit-select-catalog", "button-container-catalog");
        });

        document.getElementById("edit-select-subcatalog").addEventListener("change", function() {
            toggleButtons("edit-select-subcatalog", "button-container-subcatalog");
        });

        function toggleButtons(selectId, buttonContainer) {
            var select = document.getElementById(selectId);
            var buttons = document.querySelectorAll(`#${buttonContainer} .btn`);

            if (select.value) {
                buttons.forEach(function(button) {
                    button.style.display = 'inline-block'; // Show buttons
                });
            } else {
                buttons.forEach(function(button) {
                    button.style.display = 'none'; // Hide buttons
                });
            }
        }

        // Function to open the Edit Section modal
        function openEditSectionModal() {
            // Display the modal
            document.getElementById("edit-section-modal").style.display = "block";
            var section = document.getElementById('edit-select-section');
            var sectionIdValue = section.options[section.selectedIndex].value;
            var sectionIdSpan = document.getElementById("section-id-display");
            sectionIdSpan.textContent = sectionIdValue;

            var sectionNameValue = section.options[section.selectedIndex].text;
            var sectionNameSpan = document.getElementById("section-name-display");
            sectionNameSpan.textContent = sectionNameValue;
        }

        // Function to close the modal
        function closeSectionModal() {
            document.getElementById("edit-section-modal").style.display = "none";
        }

        // Function to open the Edit Catalog modal
        function openEditCatalogModal() {
            document.getElementById("edit-catalog-modal").style.display = "block";
            var catalog = document.getElementById('edit-select-catalog');
            var catalogIdValue = catalog.options[catalog.selectedIndex].value;
            var catalogIdSpan = document.getElementById("catalog-id-display");
            catalogIdSpan.textContent = catalogIdValue;

            var catalogNameValue = catalog.options[catalog.selectedIndex].text;
            var catalogNameSpan = document.getElementById("catalog-name-display");
            catalogNameSpan.textContent = catalogNameValue;
        }

        // Function to close the Edit Catalog modal
        function closeCatalogModal() {
            document.getElementById("edit-catalog-modal").style.display = "none";
        }

        // Function to open the Edit Subcatalog modal
        function openEditSubcatalogModal() {
            document.getElementById("edit-subcatalog-modal").style.display = "block";
            var subcatalog = document.getElementById('edit-select-subcatalog');
            var subcatalogIdValue = subcatalog.options[subcatalog.selectedIndex].value;
            var subcatalogIdSpan = document.getElementById("subcatalog-id-display");
            subcatalogIdSpan.textContent = subcatalogIdValue;

            var subcatalogNameValue = subcatalog.options[subcatalog.selectedIndex].text;
            var subcatalogNameSpan = document.getElementById("subcatalog-name-display");
            subcatalogNameSpan.textContent = subcatalogNameValue;
        }

        // Function to close the Edit Subcatalog modal
        function closeSubcatalogModal() {
            document.getElementById("edit-subcatalog-modal").style.display = "none";
        }
        </script>
        
        <script>
        // Session Handling
        const sessionData = <?php echo json_encode($_SESSION); ?>;
        if (sessionData.admin) {
            localStorage.setItem('admin', sessionData.admin);
        }
        </script>
        <script defer>
        const adminSession = localStorage.getItem('admin');
        if (adminSession) {
            console.log("User logged in. Redirecting...");
            document.getElementById('admin-name').innerHTML = "Hi! " + adminSession;

            // Send the data to the server using Fetch API (AJAX)
            fetch('../include/processLocalstorage.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json'
              },
              body: JSON.stringify({ admin: adminSession })
            })
            .then(response => response.json())
            .then(data => {
              console.log('Server response:', data);
            })
            .catch(error => console.error('Error:', error));
        } else {
            alert("Not logged in. Redirected to Admin Login.");
            window.location.href="admin-login.php";
        }
        </script>
        <script>
            window.addEventListener("beforeunload", function () {
                navigator.sendBeacon("../include/logout.php");
            });
        </script>
</body>

</html>