<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


    <!-- ######################################################## PROJECT REFERENCES - WORKS CITED ########################################################

        W3Schools Javascript Form Validation: https://www.w3schools.com/js/js_validation.asp
        MySQL Update Command: https://dev.mysql.com/doc/refman/8.0/en/update.html
        Bootstrap Grid System: https://getbootstrap.com/docs/4.1/layout/grid/
        Bootstrap Buttons: https://getbootstrap.com/docs/4.0/components/buttons/
        Bootstrap Forms: https://getbootstrap.com/docs/4.1/components/forms/
        Log Out Function Reference: https://stackoverflow.com/questions/4608182/logout-and-redirecting-session-in-php

       ######################################################### PROJECT REFERENCES - WORKS CITED ######################################################## -->

</head>

<body>
    <?php
        session_start();
        
        include "function.php";

        //echo "DEBUG: Session Login Value = " . $_SESSION['login'] . "<br>";
    
        if (!isset($_SESSION['login']) || $_SESSION['login'] == '')
        {
            echo $_SESSION['login'];
            header ("Location: ./login.html");
        } 

        //************//
    
        connectToDB();
    
        ///**********//
    
        $thisPHP = $_SERVER['PHP_SELF'];
        $databaseAction = '';
        $displayAction = 'showRecords';


        if (isset($_POST['btnSearch']))
            $databaseAction = 'doSearch';
        if (isset($_POST['btnInsert']))
            $databaseAction = 'doInsert';
        if (isset($_POST['btnDelete']))
            $databaseAction = 'doDelete';
        if (isset($_POST["btnLogOut"]))
            $databaseAction = 'doLogOut';
        if (isset($_POST["btnFullView"]))
            $databaseAction = 'doFullView';
        if (isset($_POST["btnDoEdit"]))
            $databaseAction = 'doEdit';


        if (isset($_POST['btnSearch']))
            $displayAction = 'doSearch';
        else if (isset($_POST['showInsertForm']))
            $displayAction = 'showInsertForm';
        else if (isset($_POST['btnSearchClear']))
            $displayAction = 'doSearchClear';
        else if (isset($_POST['searchDBForm']))
            $displayAction = 'searchDBForm';
        else if (isset($_POST['btnFullView']))
            $displayAction = 'showFullView';
        else if(isset($_POST["btnShowEdit"]))
            $displayAction = 'showEditForm';
        else
            $displayAction ='showRecords';



        // Insert Action
        if ($databaseAction == 'doInsert')
        {
            insertRecord();
        }

        // Search Action
        else if ($databaseAction == 'doSearch')
        {
            doSearch();
        }

        // Delete Action
        else if ($databaseAction == 'doDelete')
        {
            deleteRecord();
        }

        // Clear Search Results Action
        else if ($databaseAction == 'doSearchClear')
        {
            clearSearchQuery();
        }

        // Show Full Entry View Action
        else if ($databaseAction == 'doFullView')
        {
            displayFullViewEntry();
        }

        // Edit Entry Action
        else if ($databaseAction == 'doEdit')
        {
            editRecord();
        }

        // Log Out of Journal Action
        else if ($databaseAction == 'doLogOut')
        {
            logOut();
        }
    
        // Display Form for Inserting Entry
        if ($displayAction == 'showInsertForm')
        {
            displayInsertForm();
        }

        // Display Form for Searching Entries
        else if ($displayAction == 'searchDBForm')
        {
            displaySearchForm();
        }

        // Display Action for Clearing the Search Query
        else if ($displayAction == 'doSearchClear')
        {
            clearSearchQuery();
        }

        // Display Form For Entry Editing
        else if ($displayAction == 'showEditForm')
        {
            showEditForm();
        }

        // Default Display Action - Show All Journal Entries
        else if ($displayAction == 'showRecords')
        {
            showJournalRecords();
        }
        $conn->close();
    ?>

    <br><br><br><br><br><br>
    <footer class="page-footer font-medium blue fixed-bottom">
        <div class="footer-copyright text-center p-3 bg-primary text-white">&copy; Copyright 2018 Sal Trupiano, All Rights Reserved</div>
    </footer>


</body>

</html>
