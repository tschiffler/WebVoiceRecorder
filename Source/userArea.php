    <div id="userArea">
        <form method="post">
            <b>current User: </b>
            <span id="userName"><?php echo $_SESSION['userName']; ?></span> (<span id="userId"><?php echo $_SESSION['userId']; ?></span>)
            <button type="submit" name="logout" class="btn btn-outline-secondary"><span class="oi oi-account-logout" aria-hidden="true"></span> Logout</button>
        </form>
    </div>