<?php
include("config/config.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Register - MyADZU</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <style>
            body {
                background-color: #0a1f44;
                background-image: url('assets/img/login.png');
                background-size: cover;
                background-position: center;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
                overflow: hidden;
            }
            body::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: radial-gradient(circle at center, transparent 0%, #0a1f44 70%);
            }
            h1 {
                font-size: 2.5rem;
                font-weight: 600;
                margin-bottom: 0.5rem;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            }
            p {
                font-size: 1.1rem;
                font-weight: 300;
                margin-bottom: 2rem;
                text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
                color: black;
            }
            .register-container {
                max-width: 600px;
                width: 90%;
                padding: 20px;
                position: relative;
                z-index: 1;
                display: flex;
                align-items: center;
                flex-direction: column;
            }
            .logo {
                width: 120px;
                height: 120px;
                margin: 0 auto 20px;
                display: block;
                background-color: white;
                border-radius: 50%;
                padding: 10px;
            }
            .card {
                background-color: rgba(255, 255, 255, 0.9) !important;
                border: none;
                border-radius: 10px;
                width: 100%;
            }
            .form-control {
                background-color: rgba(255, 255, 255, 0.9);
                border: none;
                height: 48px;
                font-size: 16px;
            }
            .btn-primary {
                background-color: #ffc107;
                border-color: #ffc107;
                color: #000;
                height: 48px;
                font-size: 18px;
                font-weight: 500;
            }
            .btn-primary:hover {
                background-color: #ffca2c;
                border-color: #ffca2c;
            }
            @media (max-width: 768px) {
                .register-container {
                    width: 95%;
                    padding: 10px;
                }
                h1 {
                    font-size: 2rem;
                }
                .form-control, .btn-primary {
                    height: 40px;
                    font-size: 14px;
                }
            }
            @media (max-width: 480px) {
                h1 {
                    font-size: 1.5rem;
                }
                .card-body {
                    padding: 1rem;
                }
                .form-control, .btn-primary {
                    height: 36px;
                    font-size: 12px;
                }
            }
        </style>
    </head>
    <body>
        <div class="register-container">
            <div style="background:white; border-radius:50%; width:150px; height:150px; display:flex; justify-content:center; align-items:center; margin-bottom: 20px;">
                <img src="assets/img/CMOlogo.png" alt="Logo" style="max-width:80%; max-height:80%; object-fit:contain;">
            </div>
            <h1 class="text-center text-white mb-4">Campus Ministry Office</h1>

            <div class="card">
                <div class="card-body">
                    <h3 class="text-center font-weight-light my-4">Create Account</h3>
                    <form id="registerForm" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <div class="form-floating">
                                    <input class="form-control" id="inputFirstName" name="inputFirstName" type="text" placeholder="Enter your first name" required />
                                    <label for="inputFirstName">First name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" id="inputLastName" name="inputLastName" type="text" placeholder="Enter your last name" required />
                                    <label for="inputLastName">Last name</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <div class="input-group">
                                <input class="form-control" id="inputEmail" name="inputEmail" type="text" placeholder="Enter staff email" required />
                                <span class="input-group-text" id="basic-addon2">@adzu.edu.ph</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <div class="form-floating">
                                    <input class="form-control" id="inputPassword" name="inputPassword" type="password" placeholder="Create a password" required />
                                    <label for="inputPassword">Password</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" id="inputPasswordConfirm" name="inputPasswordConfirm" type="password" placeholder="Confirm password" required />
                                    <label for="inputPasswordConfirm">Confirm Password</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-control" id="inputType" name="inputType" required>
                                <option value="" disabled selected>Select</option>
                                <option value="Admin">Admin</option>
                                <option value="Retreat">Retreat</option>
                                <option value="Recollection 01">Recollection 01</option>
                                <option value="Recollection 02">Recollection 02</option>
                            </select>
                            <label for="inputType">Account Type</label>
                        </div>
                        <div class="mt-4 mb-0">
                            <div class="d-grid">
                                <button class="btn btn-primary btn-block" id="createAccBtn">Create Account</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center py-3">
                    <div class="small"><a href="main-page.php">Back to dashboard</a></div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="js/button-functions.js"></script>
    </body>
</html>