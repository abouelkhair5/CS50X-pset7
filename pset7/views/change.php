<form action="change.php" method="post">
    <fieldset>
        <div class="form-group">
            <input autocomplete="off" autofocus class="form-control" name="old" placeholder="Old password" type="password"/>
        </div>
        <div class="form-group">
            <input class="form-control" name="new" placeholder="New password" type="password"/>
        </div>
        <div class="form-group">
            <input class="form-control" name="confirm" placeholder="Confirm password" type="password"/>
        </div>
        <div class="form-group">
            <button class="btn btn-default" type="submit">
                <span aria-hidden="true" class="glyphicon glyphicon-ok"></span>
                Change password
            </button>
        </div>
    </fieldset>
</form>