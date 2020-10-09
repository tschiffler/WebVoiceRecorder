    <div id="userArea">
        <form method="post">
            <b>aktueller Benutzer: </b>
            <span id="userName"><?php echo $_SESSION['userName']; ?></span> (<span id="userId"><?php echo $_SESSION['userId']; ?></span>)
            <button type="submit" name="logout" class="btn btn-outline-secondary">Logout</button>
        </form>
    </div>