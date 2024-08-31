<nav class="sidebar close">
    <header>
        <div class="image-text">
            <span class="image">
                <img src="../images/citylogo.png" alt="">
            </span>

            <div class="text logo-text">
                <span class="name">Queing System</span>
                <span class="profession">Admin</span>
            </div>
        </div>

        <i class='bx bx-chevron-right toggle'></i>
    </header>

    <div class="menu-bar">
        <div class="menu">

            <ul class="menu-links">
                <li class="nav-link">
                    <a href="adminpage.php">
                        <i class='bx bx-home-alt icon'></i>
                        <span class="text nav-text">Dashboard</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="service_management.php">
                        <i class='bx bx-wallet icon'></i>
                        <span class="text nav-text">Service</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="admin_manage_admin.php">
                        <i class='bx bxs-user icon'></i>
                        <span class="text nav-text">Admin Mngt</span>
                    </a>
                </li>



                <li class="nav-link">
                    <a href="admin_manage_processor.php">
                        <i class='bx bxs-user-plus icon'></i>
                        <span class="text nav-text">Processor Mngt</span>
                    </a>
                </li>



                <li class="nav-link">
                    <a href="manage_window.php">
                        <i class='bx bx-windows icon'></i>
                        <span class="text nav-text">Window Mngt</span>
                    </a>
                </li>


                <!-- <li class="nav-link">
                    <a href="manage_window.php">
                        <i class='bx bx-windows icon'></i>
                        <span class="text nav-text">Window Mngt</span>
                    </a>
                </li> -->




            </ul>
        </div>

        <div class="bottom-content">
            <li class="">
                <a href="../logout.php">
                    <i class='bx bx-log-out icon'></i>
                    <span class="text nav-text">Logout</span>
                </a>
            </li>

        </div>
    </div>

</nav>


<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>


    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="Images/logoside.png" alt="">
                </span>

                <div class="text logo-text">
                    <span class="name">Bookdoc</span>
                    <span class="profession">Admin</span>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">

                <li class="search-box">
                    <i class='bx bx-search icon'></i>
                    <input type="text" placeholder="Search...">
                </li>


                <li class="nav-link">
                    <a href="Admin_Dashboard.html">
                        <i class='bx bx-home-alt icon'></i>
                        <span class="text nav-text">Dashboard</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="Admin_Doctors.html">
                        <i class='bx bxs-user-plus icon'></i>
                        <span class="text nav-text">Doctors</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="Admin_Patients.html">
                        <i class='bx bxs-user icon'></i>
                        <span class="text nav-text">Patients</span>
                    </a>
                </li>




            </div>

            <div class="bottom-content">
                <li class="">
                    <a href="Admin_Login.html">
                        <i class='bx bx-log-out icon'></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>


            </div>
        </div>

    </nav> -->



<script>
    const body = document.querySelector('body'),
        sidebar = body.querySelector('nav'),
        toggle = body.querySelector(".toggle"),
        searchBtn = body.querySelector(".search-box"),
        modeSwitch = body.querySelector(".toggle-switch"),
        modeText = body.querySelector(".mode-text");


    toggle.addEventListener("click", () => {
        sidebar.classList.toggle("close");
    })

    searchBtn.addEventListener("click", () => {
        sidebar.classList.remove("close");
    })

    modeSwitch.addEventListener("click", () => {
        body.classList.toggle("dark");

        if (body.classList.contains("dark")) {
            modeText.innerText = "Light mode";
        } else {
            modeText.innerText = "Dark mode";

        }
    });
</script>