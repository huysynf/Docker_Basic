<?php
require_once './public/database/mysql_li.php';

function getUser()
{
    $sql = "SELECT * from users";

    return queryRaw($sql);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP CURD </title>
    <head>
        <link rel="stylesheet" href="public/css/style.css">

        <style>
            * {
                box-sizing: border-box;
                padding: 0;
                margin: 0;
            }

            .header {
                width: 30%;
                display: flex;
                flex-direction: column;
            }

            .header__user {
                height: 10%;
                width: 100%;
                display: block;
            }

            .header__menu {
                height: 30%;
                width: 100%;
            }

            .header__menu {
                padding: 2rem;
            }

            .menu ul {
                list-style: none;
            }

            .menu ul li {
                display: block;
                border: 1px solid;
                padding: 10px;
            }

            .menu ul li:hover {
                background-color: #aaa;
            }

            .wrap {
                display: flex;
                height: 100vh;
            }

            .main {
                flex-grow: 1;
                display: flex;
                flex-direction: column;
            }

            .navbar {
                height: 10%;
            }

            .content {
                height: 80%;
                background-color: aqua;
            }

            .footer {
                height: 10%;
                text-align: center;
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: aliceblue;
            }

            .table__user {
                width: 100%;
                padding: 0 10px;
                text-align: center;
            }

            .table__user tr {
                height: 50px;
            }

            .table__user tr:hover {
                border-radius: 10px;
                background-color: azure;
            }

            .btn {
                padding: 10px;
                border-radius: 5px;
                background-color: rgb(109, 187, 109);
                color: white;
                border: none;
            }

            .btn-create-user__box {
                display: flex;
                justify-content: center;
                margin: 20px 0;
            }

            .form-user--create {
                padding: 20px;
            }

            .form-control {
                display: flex;
                width: 100%;
                margin: 20px;
            }

            .form-control label {
                width: max-content;
                width: 100px;
                text-transform: capitalize;
            }

            .form-control .input-text:hover, .form-control .input-text:focus {
                background-color: lightcyan;
            }

            .form-control .input-text {
                height: 20px;
                width: 80%;
                outline: unset;
                border-color: rgb(170, 161, 179);
                background-color: rgba(170, 170, 170, 0.226);
                border-radius: 5px;
                padding: 20px 20px;
            }

            .btn-danger {
                background-color: rgb(199, 21, 74);

            }

            .btn-warning {
                background-color: rgb(219, 110, 91);
            }

        </style>
    </head>
</head>
<body class="wrap">
<header class="header">
    <div class="header__user">

    </div>
    <nav class="menu header__menu">
        <ul>
            <li>
                <a href="">Home</a>

            </li>

            <li>
                <a href="">User</a>
            </li>
        </ul>
    </nav>
</header>

<div class="main">
    <nav class="navbar">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="msg">
                <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                ?>
            </div>
        <?php endif ?>
    </nav>

    <main class="content">

        <h1>
            MANAGE USERS
        </h1>


        <div class="create_user_box">
            <div class="btn-create-user__box">
                <button class="btn btn-user-create">Add User</button>
            </div>
            <div>
                <div>
                    <form action="./public/database/mysql_li.php" method="post" class="form-user--create">
                        <div class="form-control">
                            <label for="">Name</label>
                            <input class="input-text" type="text" required name="name">
                        </div>
                        <div class="form-control">
                            <label for="">Email</label>
                            <input class="input-text" type="email" name="email">
                        </div>
                        <div class="form-control">
                            <label for="">password</label>
                            <input class="input-text" type="password" name="password">
                        </div>
                        <div class="form-control">
                            <label for="">address</label>
                            <textarea class="input-text" name="address" cols="10">
                                dadas
                            </textarea>
                        </div>
                        <div class="form-control">
                            <label for="">gender</label>

                            <input type="radio" name="gender" value="Male"> Male
                            <input type="radio" name="gender" value="FeMale"> FeMale

                        </div>

                        <div class="form-control">
                            <button class="btn btn-create" name="create" type="submit">create</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="listUser">
                <table class="table__user">
                    <tr>
                        <td>ID</td>
                        <td>name</td>
                        <td>email</td>
                        <td>gender</td>
                        <td>address</td>
                        <td>action</td>

                    </tr>

                    <?php while ($row = mysqli_fetch_array(getUser())){ ?>

                             <tr>
                        <td>1</td>
                        <td>name</td>
                        <td>email</td>
                        <td>gender</td>
                        <td>address</td>

                        <td>
                            <button class="btn btn-warning">Edit</button>
                            <button class="btn btn-danger">Delete</button>

                        </td>
                    </tr>

                    <?php } ?>

                </table>


            </div>
    </main>

    <footer class="footer">
        <p>@CopyRight by Huyhq</p>
    </footer>
</div>
</body>

<script src="public/js/script.js"></script>
</html>
