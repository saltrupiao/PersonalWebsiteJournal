<?php

// Create a new connection to access the MySQL Database
function connectToDB()
{   
    global $conn;
    
    $servername = "localhost";
    $username = "root";
    //$username = "strupiano";
    $password = "oakland";
    $dbname = "journal";
    //$dbname = "strupiano";

	$conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

}


// Insert a Record into the Database - Database Action
function insertRecord()
{
    global $conn;
    
    $eDate = $_POST['eDate'];
    $eTitle = $_POST['eTitle'];
    $eText = $_POST['eText'];
    $eURL = $_POST['eURL'];
    $eGroup = $_POST['eGroup'];

    if (!empty($eTitle) || !empty($eText)){
        $sql = "insert into entry(eDate, eTitle, eText, eURL, eGroup)" . " values ('$eDate', '$eTitle', '$eText', '$eURL', '$eGroup')";
        if ($conn->query ($sql) == TRUE) {
            //echo "DEBUG: Record added <br>";
        }
        else
        {
            echo "Could not add record: " . $conn->connect_error . "<br>";
        }
    } 
    else
    {
        echo "Must provide Entry Title and Text to enter a record <br>";
        $action = 'showInsertForm';
    }

}


// Delete a Record from the Database - Database Action
function deleteRecord()
{
    global $conn;
    $eId = $_POST['eId'];
    if (!empty($eId)){
        $sql = "DELETE FROM entry WHERE eId = '$eId'";
        //echo $sql . "<br>";
        if ($conn->query ($sql) == TRUE) {
            //echo "DEBUG: Record deleted <br>";
        }
        else
        {
            echo "Could not delete record: " . $conn->connect_error . "<br>";
        }
    }
    else
    {
        echo "Must provide an Entry ID to delete a record a record <br>";
    }
}


// Display all Journal Entries in a Table - Default Display Action
function showJournalRecords()
{
    global $conn;
    global $thisPHP;

    echo "<nav class='navbar navbar-expand-lg navbar-dark bg-primary'>
            <a class='navbar-brand' href='index.html'>Sal</a>
            <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarNavDropdown' aria-controls='navbarNavDropdown' aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
            </button>
            <div class='collapse navbar-collapse' id='navbarNavDropdown'>
                <ul class='navbar-nav'>
                    <li class='nav-item'>
                        <a class='nav-link' href='index.html'>Home <span class='sr-only'>(current)</span></a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='links.html'>Links</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='projects.html'>Projects</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='courses.html'>Courses</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='funfacts.html'>Hobbies</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='contact.html'>Contact</a>
                    </li>
                    <li class='nav-item active'>
                        <a class='nav-link' href='journalDB.php'>Journal <img src='lock-locked-2x.png' style='display:inline;'></a>
                    </li>
                </ul>
            </div>
          </nav>";

    echo "<div class='container-fluid'>";
    echo "<h1 class='display-1' style='text-align:center'>Personal Journal</h1><br>";
    echo "<nav class='navbar navbar-expand-lg navbar-dark bg-primary'>
            <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarNavDropdown2' aria-controls='navbarNavDropdown' aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
            </button>
            <div class='collapse navbar-collapse mx-auto' id='navbarNavDropdown2'>
                <ul class='navbar-nav mx-auto'>
                    <li class='nav-item active mx-auto'>
                        <a class='btn btn-primary active' href='journalDB.php' role='button'>Journal Home</a>
                    </li>
                    <form id='insertForm' action='{$thisPHP}' method='post' style='display:inline'>
                        <li class='nav-item' style='display:inline'>
                            <input class='btn btn-primary' type='submit' name='showInsertForm' value='Add New Entry'>
                        </li>
                        <li class='nav-item' style='display:inline'>
                            <input class='btn btn-primary' type='submit' name='searchDBForm' value='Search for Entry'>
                        </li>
                    </form>
                </ul>
                <ul class='navbar-nav'>
                    <li class='nav-item'>
                        <form id='logoutForm' action='{$thisPHP}' method='post'>
                            <input class='btn btn-primary' type='submit' name='btnLogOut' value='Logout'><img src='account-logout-3x.png' style='display:inline;'>
                        </form>
                    </li>
                </ul>
            </div>
          </nav>
          </div>";


    $sql = "SELECT * FROM entry ORDER BY eGroup, eDate DESC";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) 
    {         
        echo "<br><br><br>";
        echo "<h3 style='text-align:center;'>Journal Entries</h3>";
        echo "<div class='container-fluid'>";
        echo "<table class='table table-sm table-bordered table-striped table-hover'>";
        echo "<thead><tr class='table-primary'> <th scope='col'>Entry ID</th> <th scope='col'>Entry Date</th> <th scope='col'>Entry Title</th> <th scope='col'>Entry Text</th><th scope='col'>Entry URL</th> ";
        echo "<th scope='col'>Entry Group</th> <th scope='col'>Delete?</th><th scope='col'>Edit</th></tr></thead>";
        while($row = $result->fetch_assoc())
        {
            echo "<tbody><tr>";

            $eId = $row["eId"];

            echo  "<form action='{$thisPHP}' method='post'><td><input type='hidden' name='eId' value='{$eId}'>" . $eId . "  </td> <td class='text-nowrap'> " . $row["eDate"] .
                  " </td> <td class='text-nowrap'><input type='submit' class='btn btn-outline-primary' style='width:100%' name='btnFullView' value='{$row['eTitle']}'> </td><td> " . $row["eText"] .
    		      " </td> <td><a href='{$row['eURL']}' target='_blank'>" . $row["eURL"] .
                  "</a></td>  <td> " . $row["eGroup"] .
                  "</td> </form>";

            echo "<form action='{$thisPHP}' method='post' style='display:inline' >";
            echo "<input type='hidden' name='eId' value='{$eId}'>";
            echo "<td><input class='btn btn-danger' type ='submit' name='btnDelete' value='Delete'></td>";
            echo "<td><input type='submit' class='btn btn-info' name='btnShowEdit' value='Edit'>";
            echo "</td>";

            echo "</tr></form></tbody>";
        }
        echo "</table>";
        echo "</div>";
    } 
    else 
    {
        echo "0 results";
    }
}


// Display Specific Entry When Title is Clicked
function displayFullViewEntry()
{
    global $conn;
    global $thisPHP;

    $eId = $_POST['eId'];

    $sql = "SELECT * FROM entry WHERE eId = '$eId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0)
    {
        echo "<div class='container' style='align-content:center'>";
        while($row = $result->fetch_assoc()) {
            echo "<h1 class='display-1' style='text-align:center;'>Personal Journal</h1><br>";
            echo "<p class='lead' style='text-align:center;'><i>New Viewing: " . $row['eTitle'] . "</i></p>";
            echo " <div class='row border border-primary'>
                        <div class='col-sm-4' style='text-align:center;'>
                            <label><b>Entry ID: </b></label><p>$eId</p>
                        </div>
                        <div class='col-sm-4' style='text-align:center;'>
                            <label><b>Entry Date: </b></label><p>{$row['eDate']}</p>
                        </div>
                        <div class='col-sm-4' style='text-align:center;'>
                            <label><b>Entry Category: </b></label><p>{$row['eGroup']}</p>
                        </div>
                   </div><br><br>
                   <div class='row' style='text-align:center;'>
                        <h2>{$row['eTitle']}</h2>
                   </div>
                   <div class='row'>
                        <p class='lead'>{$row['eText']}</p>
                   </div>
                   <div class='row'>
                        <label><b>Entry URL: </b></label>
                        <a href='{$row['eURL']}' target='_blank'>{$row['eURL']}</a>
                   </div><br>
                   <form action='{$thisPHP}' method='post'>
                        <input type='submit' class='btn btn-outline-secondary' name='btnCloseFullView' value='<--- Back to Journal Entries'>
                   </form>
            </div>";
        }
    }
}


// Show Edit Form when Edit Button is Clicked - Display Action
function showEditForm()
{
    global $conn;
    global $thisPHP;

    echo "<nav class='navbar navbar-expand-lg navbar-dark bg-primary'>
        <a class='navbar-brand' href='index.html'>Sal</a>
        <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarNavDropdown' aria-controls='navbarNavDropdown' aria-expanded='false' aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon'></span>
        </button>
        <div class='collapse navbar-collapse' id='navbarNavDropdown'>
            <ul class='navbar-nav'>
                <li class='nav-item'>
                    <a class='nav-link' href='index.html'>Home <span class='sr-only'>(current)</span></a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='links.html'>Links</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='projects.html'>Projects</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='courses.html'>Courses</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='funfacts.html'>Hobbies</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='contact.html'>Contact</a>
                </li>
                <li class='nav-item active'>
                    <a class='nav-link' href='journalDB.php'>Journal <img src='lock-locked-2x.png' style='display:inline;'></a>
                </li>
            </ul>
        </div>
    </nav>";

    echo "<div class='container-fluid'>";
    echo "<h1 class='display-1' style='text-align:center'>Personal Journal</h1><br>";
    echo "<nav class='navbar navbar-expand-lg navbar-dark bg-primary'>
            <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarNavDropdown2' aria-controls='navbarNavDropdown' aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
            </button>

            <div class='collapse navbar-collapse mx-auto' id='navbarNavDropdown2'>
                <ul class='navbar-nav mx-auto'>
                    <li class='nav-item active mx-auto'>
                        <a class='btn btn-primary active' href='journalDB.php' role='button'>Journal Home</a>
                    </li>
                    <form id='insertForm' action='{$thisPHP}' method='post' style='display:inline'>
                        <li class='nav-item' style='display:inline'>
                            <input class='btn btn-primary' type='submit' name='showInsertForm' value='Add New Entry'>
                        </li>
                        <li class='nav-item' style='display:inline'>
                            <input class='btn btn-primary' type='submit' name='searchDBForm' value='Search for Entry'>
                        </li>
                    </form>
                </ul>
                <ul class='navbar-nav'>
                    <li class='nav-item'>
                        <form id='logoutForm' action='{$thisPHP}' method='post'>
                            <input class='btn btn-primary' type='submit' name='btnLogOut' value='Logout'><img src='account-logout-3x.png' style='display:inline;'>
                        </form>
                    </li>
                </ul>
            </div>
          </nav>
          </div>";

    $eId = $_POST['eId'];

    $sql = "SELECT * FROM entry WHERE eId = '$eId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<br><br><br>";
        echo "<h3 style='text-align:center;'>Edit Journal Entry</h3>";
        while ($row = $result->fetch_assoc()) {
            echo "<div class='container'>";
            echo "<form action='{$thisPHP}' method='post'>
                    <div class='form-group'>
                        <label>Entry Title </label>
                        <input type='text' class='form-control' name='eTitleNew' placeholder='50 Characters Maximum' maxlength='50' value='{$row['eTitle']}'>
                    </div>
                    <div class='form-group'>
                        <label>Entry Text </label>
                        <textarea class='form-control' name='eTextNew' rows='5' maxlength='600'>{$row['eText']}</textarea>
                    </div>
                    <div class='form-group'>
                        <label>Entry URL </label>
                        <input type='text' class='form-control' name='eURLNew' maxlength='200' placeholder='Enter Entry URL if applicable' value={$row['eURL']}>
                    </div>
                    <input type='hidden' name='eId' value='{$eId}'>
                    <input class='btn btn-primary' type='submit' name='btnDoEdit' value='Save Changes'>
                    <input class='btn btn-danger' type='submit' name='btnDiscardEdit' value='Discard Changes'>
                  </form>";
            echo "</div>";
        }
    }
}


// Edit the Chosen Entry - Database Action
function editRecord()
{
    global $conn;

    $eId = $_POST['eId'];

    $eTitleNew = $_POST['eTitleNew'];
    $eTextNew = $_POST['eTextNew'];
    $eURLNew = $_POST['eURLNew'];

    if (!empty($eId))
    {
        if (!empty($eTitleNew))
        {
            $sqlTitle = "UPDATE entry SET eTitle='$eTitleNew' WHERE eId='$eId'";
            if ($conn->query ($sqlTitle) == TRUE) {
                //echo "DEBUG: Record deleted <br>";
            }
            else
            {
                echo "Could not edit entry title: " . $conn->connect_error . "<br>";
            }
        }
        if (!empty($eTextNew))
        {
            $sqlText = "UPDATE entry SET eText='$eTextNew' WHERE eId='$eId'";
            if ($conn->query ($sqlText) == TRUE) {
                //echo "DEBUG: Record deleted <br>";
            }
            else
            {
                echo "Could not edit entry text: " . $conn->connect_error . "<br>";
            }
        }
        if (!empty($eURLNew))
        {
            $sqlURL = "UPDATE entry SET eURL='$eURLNew' WHERE eId='$eId'";
            if ($conn->query ($sqlURL) == TRUE) {
                //echo "DEBUG: Record deleted <br>";
            }
            else
            {
                echo "Could not edit entry URL: " . $conn->connect_error . "<br>";
            }
        }
        else
        {
            //echo "Could not edit record: " . $conn->connect_error . "<br>";
        }
    }
}


// Display the Insert Entry Form - Display Action
function displayInsertForm()
{
    global $thisPHP;

    $str = <<<EOD
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="index.html">Sal</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.html">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="links.html">Links</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="projects.html">Projects</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="courses.html">Courses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="funfacts.html">Hobbies</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.html">Contact</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="journalDB.php">Journal <img src="lock-locked-2x.png" style="display:inline;"></a>
                </li>
            </ul>
        </div>
    </nav>
    
    <div class="container-fluid">
        <h1 class="display-1" style="text-align:center;">Personal Journal</h1><br>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary" style="align-content:center;">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown2" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse mx-auto" id="navbarNavDropdown2">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item mx-auto">
                        <a class="btn btn-primary" href="journalDB.php" role="button">Journal Home</a>
                    </li>
                    <form id="insertForm" action='{$thisPHP}' method='post' style='align-content:center;'>
                        <li class="nav-item active" style="display:inline">
                            <input class="btn btn-primary active" type="submit" name="showInsertForm" value="Add New Entry">
                        </li>
                        <li class="nav-item" style="display:inline">
                            <input class="btn btn-primary" type="submit" name="searchDBForm" value="Search for Entry">
                        </li>
                    </form>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <form id="logoutForm" action='{$thisPHP}' method='post'>
                            <input class='btn btn-primary' type='submit' name='btnLogOut' value='Logout'><img src='account-logout-3x.png' style='display:inline;'>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <div class="container">
        <br><br><h3 style="text-align:center;">New Journal Entry</h3>
        <form action='{$thisPHP}' method='post' id="insertEntry" class="needs-validation" novalidate>
            <div class="form-group">
                <label for="validateDate">Entry Date </label>
                <input type="date" class="form-control" name="eDate" placeholder="YYYY-MM-DD" required>
                <div class="invalid-feedback">You must enter a date.</div>
            </div>
            <div class="form-group">
                <label for="validateTitle">Entry Title </label>
                <input type="text" class="form-control" id="validateTitle" name="eTitle" placeholder="50 Characters Maximum" maxlength="50" required>
                <div class="valid-feedback">Great Title!</div>
                <div class="invalid-feedback">Oops, you forgot your entry title!</div>
                <div id="validateTitleLength" class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="validateText">Entry Text </label>
                <textarea class="form-control" id="validateText" name="eText" rows="5" maxlength="600"></textarea>
                <small id="characterLimit" class="form-text text-muted"></small>
                <div class="invalid-feedback">Did you put an apostrophe in here? Those are not allowed!</div>
            </div>
            <div class="form-group">
                <label>Entry URL </label>
                <input type="url" class="form-control" name="eURL" maxlength="200" placeholder="Enter Entry URL if applicable" pattern="((file|http|https):\/\/?)\w*([\.\/-]\w+)*(\/|)\w*\..+">
                <!--REGULAR EXPRESSION IN PATTERN ATTRIBUTE USED ABOVE FOR VALIDATION OF URL  THIS DOES UTILIZE JAVASCRIPT -->
                <div class="invalid-feedback">Your URL does not seem to be valid! Check it over and try again</div>
            </div>
            <div class="form-group">
                <label for="validateCategory">Entry Category</label>
                <select class="form-control" id="validateCategory" name="eGroup" required>
                    <option>None</option>
                    <option>Home</option>
                    <option>Work</option>
                    <option>Fun</option>
                    <option>Personal</option>
                </select>
                <div class="invalid-feedback">You must categorize your entry.</div>
            </div>
            <input type="submit" class="btn btn-primary" name="btnInsert" id="btnInsert" value="Add Entry" onclick="validateForm()"><br>
        </form>
        <script>
        function validateForm()
        {
            
            var insertEntryFormObject = document.getElementById('insertEntry');

            var url = insertEntryFormObject.eURL.value;
            
            if (url != "")
            {
                if (!validateURL(url))
                {
                    //alert("URL is Invalid");
                }
            }
        }

        function validateURL(eURL)
        {
            var urlValidate = eURL.search(/((file|http|https):\/\/?)\w*([\.\/-]\w+)*(\/|)\w*\..+/g)

            if (urlValidate == 0)
            {
                return true;
            } else {
                return false;
            }
        }
        
    </script>
        <script>
            //Use of the invalid and valid feedback classes, along with general syntax for stopping submission when invalid referenced from: https://getbootstrap.com/docs/4.1/components/forms/#validation
            (function() {
                'use strict';
                window.addEventListener('load', function() {
                    var forms = document.getElementsByClassName('needs-validation');
                    var validation = Array.prototype.filter.call(forms, function(form) {
                        form.addEventListener('submit', function(event) {
                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add('was-validated');
                        }, false);
                    });
                }, false);
            }) ();
        </script>
    </div>
EOD;
    echo $str;
}


// Display the Search Form - Display Action
function displaySearchForm()
{
    global $thisPHP;

    echo "<nav class='navbar navbar-expand-lg navbar-dark bg-primary'>
            <a class='navbar-brand' href='index.html'>Sal</a>
            <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarNavDropdown' aria-controls='navbarNavDropdown' aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
            </button>
            <div class='collapse navbar-collapse' id='navbarNavDropdown'>
                <ul class='navbar-nav'>
                    <li class='nav-item'>
                        <a class='nav-link' href='index.html'>Home <span class='sr-only'>(current)</span></a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='links.html'>Links</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='projects.html'>Projects</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='courses.html'>Courses</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='funfacts.html'>Hobbies</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='contact.html'>Contact</a>
                    </li>
                    <li class='nav-item active'>
                        <a class='nav-link' href='journalDB.php'>Journal <img src='lock-locked-2x.png' style='display:inline;'></a>
                    </li>
                </ul>
            </div>
          </nav>";

    echo "<div class='container-fluid'>";
    echo "<h1 class='display-1' style='text-align:center'>Personal Journal</h1><br>";
    echo "<nav class='navbar navbar-expand-lg navbar-dark bg-primary'>
            <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarNavDropdown2' aria-controls='navbarNavDropdown' aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
            </button>

            <div class='collapse navbar-collapse mx-auto' id='navbarNavDropdown2'>
                <ul class='navbar-nav mx-auto'>
                    <li class='nav-item mx-auto'>
                        <a class='btn btn-primary' href='journalDB.php' role='button'>Journal Home</a>
                    </li>
                    <form id='insertForm' action='{$thisPHP}' method='post' style='display:inline'>
                        <li class='nav-item' style='display:inline'>
                            <input class='btn btn-primary' type='submit' name='showInsertForm' value='Add New Entry'>
                        </li>
                        <li class='nav-item active' style='display:inline'>
                            <input class='btn btn-primary active' type='submit' name='searchDBForm' value='Search for Entry'>
                        </li>
                    </form>
                </ul>
                <ul class='navbar-nav'>
                    <li class='nav-item'>
                        <form id='logoutForm' action='{$thisPHP}' method='post'>
                            <input class='btn btn-primary' type='submit' name='btnLogOut' value='Logout'><img src='account-logout-3x.png' style='display:inline;'>
                        </form>
                    </li>
                </ul>
            </div>
          </nav>
          </div>";

    echo   "<div class='container text-center'>
                <br><br><br>
                <h4 style='text-align:center;'>Search Journal Entries</h4><br>
                <form action='{$thisPHP}' method='post' id='searchForm' class='form-inline justify-content-center'>
                    <label>Search Query: </label>&nbsp;&nbsp;
                    <input type=‘text’ name='searchDBInput' size='50' placeholder='Partial or Full Entry Title'>&nbsp;&nbsp;&nbsp;
                    <input class='btn btn-primary' type='submit' name='btnSearch' id='btnSearch' value='Search'>
                </form>
            </div>";

}


// Search for Entry and Display to User - Database Action
function doSearch()
{
    global $conn;
    global $thisPHP;

    echo "<nav class='navbar navbar-expand-lg navbar-dark bg-primary'>
            <a class='navbar-brand' href='index.html'>Sal</a>
            <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarNavDropdown' aria-controls='navbarNavDropdown' aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
            </button>
            <div class='collapse navbar-collapse' id='navbarNavDropdown'>
                <ul class='navbar-nav'>
                    <li class='nav-item'>
                        <a class='nav-link' href='index.html'>Home <span class='sr-only'>(current)</span></a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='links.html'>Links</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='projects.html'>Projects</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='courses.html'>Courses</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='funfacts.html'>Hobbies</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='contact.html'>Contact</a>
                    </li>
                    <li class='nav-item active'>
                        <a class='nav-link' href='journalDB.php'>Journal <img src='lock-locked-2x.png' style='display:inline;'></a>
                    </li>
                </ul>
            </div>
          </nav>";

    echo "<div class='container-fluid'>";
    echo "<h1 class='display-1' style='text-align:center'>Personal Journal</h1><br>";
    echo "<nav class='navbar navbar-expand-lg navbar-dark bg-primary'>
            <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarNavDropdown2' aria-controls='navbarNavDropdown' aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
            </button>
            <div class='collapse navbar-collapse mx-auto' id='navbarNavDropdown2'>
                <ul class='navbar-nav mx-auto'>
                    <li class='nav-item mx-auto'>
                        <a class='btn btn-primary' href='journalDB.php' role='button'>Journal Home</a>
                    </li>
                    <form id='insertForm' action='{$thisPHP}' method='post' style='display:inline'>
                        <li class='nav-item' style='display:inline'>
                            <input class='btn btn-primary' type='submit' name='showInsertForm' value='Add New Entry'>
                        </li>
                        <li class='nav-item active' style='display:inline'>
                            <input class='btn btn-primary active' type='submit' name='searchDBForm' value='Search for Entry'>
                        </li>
                    </form>
                </ul>
                <ul class='navbar-nav'>
                    <li class='nav-item'>
                        <form id='logoutForm' action='{$thisPHP}' method='post'>
                            <input class='btn btn-primary' type='submit' name='btnLogOut' value='Logout'><img src='account-logout-3x.png' style='display:inline;'>
                        </form>
                    </li>
                </ul>
            </div>
          </nav>
          </div>";

    $searchIn = $_POST['searchDBInput'];

    $sql = "SELECT * FROM entry WHERE eTitle LIKE '%$searchIn%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0)
    {
        echo "<br><br><br>";
        if (!empty($searchIn))
        {
            echo "<div class='container' style='align-content: center;'>";
            echo "<h3 style='text-align: center;'>Results For: " . $searchIn . "<form id='insertForm' action='{$thisPHP}' method='post'><input class='btn btn-danger' type='submit' name='btnSearchClear' value='Clear Search Query'></form></h3>";
            echo "</div>";
        }

        echo "<div class='container-fluid'>";
        echo "<br><table class='table table-sm table-bordered table-striped table-hover'>";
        echo "<thead><tr class='table-primary'> <th scope='col'>Entry ID</th> <th scope='col'>Entry Date</th> <th scope='col'>Entry Title </th> <th scope='col'>Entry Text</th><th scope='col'>Entry URL</th> ";
        echo "<th scope='col'>Entry Group</th><th scope='col'>Delete?</th></tr></thead>";
        while($row = $result->fetch_assoc())
        {
            echo "<tbody><tr>";
            $eId = $row["eId"];
            echo  "<td>" . $eId . "  </td> <td class='text-nowrap'> " . $row["eDate"] .
                " </td> <td class='text-nowrap'> " . $row["eTitle"] .
                " </td> <td> " . $row["eText"] .
                "</td><td><a href='{$row['eURL']}' target='_blank'> " . $row["eURL"] .
                "</a></td>  <td> " . $row["eGroup"] .
                "</td>  <td>";

            echo "<form action='{$thisPHP}' method='post' style='display: inline;' >";
            echo "<input type='hidden' name='eId' value='{$eId}'>";
            echo "<input type='submit' name='btnDelete' value='Delete'></form>";
            echo "</td></tr></tbody>";
        }

        echo "</table>";
        echo "</div>";
    }
    else {
        echo "<div class='container text-center'>";
        echo "<h4 style='text-align:center'>Search Journal Entries</h4><br><br><br>";
        echo "<h5 style='display:inline'>No Results Found For: " . $searchIn . "</h5>&nbsp;&nbsp;&nbsp;";
        echo "<form id='insertForm' class='form-inline justify-content-center' action='{$thisPHP}' method='post' style='display:inline'><input class='btn btn-danger' type='submit' name='btnSearchClear' value='Clear Search Query'></form><br>";
        echo "</div>";
    }
}


// Clear Search Result and Go back to Search Page - Database Action
function clearSearchQuery()
{
    $searchIn = NULL;
    displaySearchForm();
}


// Logout Function referenced from StackOverflow: https://stackoverflow.com/questions/4608182/logout-and-redirecting-session-in-php
// Unset the Session Variable and go to JournalDB.php, which will redirect to login.html
function logOut()
{
    session_start();
    unset($_SESSION["login"]);
    header("Location: journalDB.php");
}


?>
