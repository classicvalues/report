<?PHP

namespace ReportInterface;

class OptionsPage extends Page
{
    public function __construct()
    {
        global $mysql;
        if (isset($_POST['submit'])) {
            if (isset($_POST['next_on_review']) && $_POST['next_on_review'] === "Yes") {
                $next_on_review = 1;
            } else {
                $next_on_review = 0;
            }

            $query = "UPDATE `users` SET `next_on_review` = '" . mysqli_real_escape_string($mysql, $next_on_review) . "'";
            $_SESSION['next_on_review'] = ($next_on_review) ? true : false;

            $query .= " WHERE `userid` = '" . mysqli_real_escape_string($mysql, $_SESSION['userid']) . "'";
            mysqli_query($mysql, $query);

            header('Location: ?page=Options&done');
            die();
        }
    }

    public function writeHeader()
    {
        echo 'Options';
    }

    public function writeContent()
    {
        if (isset($_GET['done'])) {
            echo '<p>Saved!</p>';
        }
        echo '<form action="" method="post">';

        echo '<h3>General options</h3>';
        echo '<p>Redirect on review: <input type="checkbox" id="next_on_review" name="next_on_review" value="Yes"';
        echo ($_SESSION['next_on_review']) ? ' checked=checked' : '';
        echo ' /></p>';

        echo '<p><input id="submit" name="submit" type="submit" value="Save" /></p>';
        echo '</form>';
    }
}

if (isset($_SESSION['username'])) {
    Page::registerPage('Options', 'OptionsPage', 5, true, false);
}
