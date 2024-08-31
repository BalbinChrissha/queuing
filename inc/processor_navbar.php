<nav class="sidebar close">
    <header>
        <div class="image-text">
            <span class="image">
                <img src="../images/citylogo.png" alt="">
            </span>

            <div class="text logo-text">
                <span class="name">Queing System</span>
                <span class="profession">Processor</span>
            </div>
        </div>

        <i class='bx bx-chevron-right toggle'></i>
    </header>

    <div class="menu-bar">
        <div class="menu">

            <ul class="menu-links">
                <li class="nav-link">
                    <a href="processorpage.php">
                        <i class='bx bx-home-alt icon'></i>
                        <span class="text nav-text">Dashboard</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="view_report_daily.php">
                        <i class='bx bx-wallet icon'></i>
                        <span class="text nav-text">View Report Daily</span>
                    
                    </a>
                </li>


                <li class="nav-link">
                <a href="view_report.php">
                        <i class='bx bx-windows icon'></i>
                        <span class="text nav-text">View Report Monthly</span>
                    </a>
                </li>

                <li class="nav-link">
                <a href="check_report_year.php">
                        <i class='bx bxs-file icon'></i>
                        <span class="text nav-text">View Report Yearly</span>
                    </a>
                </li>



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