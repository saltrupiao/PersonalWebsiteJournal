<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>

<?php

echo "<h1>Edit Entry</h1>";

echo "<nav class=\"navbar navbar-expand-lg navbar-dark bg-primary\">
        <a class=\"navbar-brand\" href=\"index.html\">Sal</a>
        <button class=\"navbar-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarNavDropdown\" aria-controls=\"navbarNavDropdown\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
            <span class=\"navbar-toggler-icon\"></span>
        </button>
        <div class=\"collapse navbar-collapse\" id=\"navbarNavDropdown\">
            <ul class=\"navbar-nav\">
                <li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"index.html\">Home <span class=\"sr-only\">(current)</span></a>
                </li>
                <li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"links.html\">Links</a>
                </li>
                <li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"projects.html\">Projects</a>
                </li>
                <li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"courses.html\">Courses</a>
                </li>
                <li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"funfacts.html\">Hobbies</a>
                </li>
                <li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"contact.html\">Contact</a>
                </li>
                <li class=\"nav-item active\">
                    <a class=\"nav-link\" href=\"journalDB.php\">Journal <img src=\"lock-locked-2x.png\" style=\"display:inline;\"></a>
                </li>
            </ul>
        </div>
    </nav>";

echo "<div class='container-fluid'>";
echo "<h1 class='display-1' style='text-align:center'>Personal Journal</h1><br>";
echo "<nav class='navbar navbar-expand-lg navbar-dark bg-primary' style='align-content:center'>
    <button class=\"navbar-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarSupportedContent\" aria-controls=\"navbarSupportedContent\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
    <span class=\"navbar-toggler-icon\"></span>
    </button>

    <div class='collapse navbar-collapse mx-auto' id='navbar'>
        <ul class='navbar-nav mx-auto'>
            <li class='nav-item active'>
                <!--<a class='navbar-brand' href='journalDB.php'>Journal Home</a>-->
                <a class='btn btn-primary active' href='journalDB.php' role='button'>Journal Home</a>
            </li>
            <li>
                <form id='insertForm' action='{$thisPHP}' method='post'>
                    <!--<a class='navbar-brand button' name='showInsertForm' href='#'>Add New Entry</a>-->
                    <input class='btn btn-primary' type='submit' name='showInsertForm' value='Add New Entry'>
                    <input class='btn btn-primary' type='submit' name='searchDBForm' value='Search for Entry'>
                </form>
            </li>
        </ul>
        <ul class='navbar-nav ml-auto'>
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

$sql = "SELECT * FROM entry WHERE eId = '$eId' ORDER BY eGroup, eDate, DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<br><br><br>";
    echo "<h3 style='text-align:center;'>Journal Entries</h3>";
    while ($row = $result->fetch_assoc()) {

        echo "<form action='{$thisPHP}' method='post'>
                <div class='form-group'>
                    <label>Entry Date </label>
                    <input type='date' class='form-control' name='eDateNew' value='{$row['eDate']}'>
                </div>
                <div class='form-group'>
                    <label>Entry Title </label>
                    <input type='text' class='form-control' name='eTitleNew' placeholder='50 Characters Maximum' maxlength='50' value='{$row['eTitle']}'>
                </div>
                <div class='form-group'>
                    <label>Entry Text </label>
                    <textarea class='form-control' name='eTextNew' rows='5' maxlength='600'>'{$row['eText']}'</textarea>
                </div>
                 <div class='form-group'>
                    <label>Entry URL </label>
                    <input type='text' class='form-control' name='eURLNew' maxlength='200' placeholder='Enter Entry URL if applicable' value=''{$row['eURL']}''>
                 </div>
                 <div class='form-group'>
                    <label>Entry Category</label>
                    <select class='form-control' name='eGroupNew'>
                        <option>Home</option>
                        <option>Work</option>
                        <option>Fun</option>
                        <option>Personal</option>
                    </select>
                 </div>
                 <input class='btn btn-primary' type='submit' name='btnDoEdit' value='Save Changes'>
               </form>";
    }
}

?>

</body>

</html>
