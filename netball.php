<?php
$conn = new mysqli("localhost", "myuser", "mypass", "mydb");
$mode = 'list';
if (isset($_REQUEST['mode']))
    $mode = $_REQUEST['mode'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Netball database</title>
</head>
<body>
<ul>
    <li><a href="?mode=list"> DONE List teams</a>
    <li><a href="?mode=coaches"> DONE List teams with coaches</a>
    <li><a href="?mode=coaches_captains"> DONE List teams with coaches and captains</a>
    <li><a href="?mode=list_players"> DONE List players on a particular team</a>
    <li><a href="?mode=show_player"> DONE Show individual player bio details, including team and
            positions</a>
    <li><a href="?mode=list_positions"> DONE List players on a particular team who play a particular
            position</a>
    <li><a href="?mode=edit_player">Edit a player</a>
    <li><a href="?mode=remove_player">Remove player</a>
    <li><a href="?mode=add_player">Add new player</a>
    <li><a href="?mode=results_table">Generate a table of results across the league</a>
</ul>
<?php
if ($mode == 'list') {
    ?>
    <h1>List of teams</h1>
    <table>
        <?php
        $result = $conn->query("SELECT * FROM teams;");
        foreach ($result as $row) {
            ?>
            <tr>
                <td><?php echo $row['name'] ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
    <?php
} else if ($mode == 'coaches') {
    ?>
    <h1>List of teams w coaches</h1>
    <table>
        <?php
        $result = $conn->query("SELECT teams.name as name, coaches.name as coach from teams,coaches where coaches.id = teams.coach");
        foreach ($result as $row) {
            ?>
            <tr>
                <td><?php echo $row['name'] ?></td>
                <td><?php echo $row ['coach'] ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
    <?php
} else if ($mode == 'coaches_captains') {
    ?>
    <h1>List of teams w coaches + captains</h1>
    <table>
        <?php
        $result = $conn->query("select teams.name as Team, coaches.name as `Coach name`, players.name as Captain from teams, coaches, players where players.id = teams.captain and coaches.id = teams.coach");
        foreach ($result as $row) {
            ?>
            <tr>
                <td><?php echo $row['Team'] ?></td>
                <td><?php echo $row ['Coach name'] ?></td>
                <td><?php echo $row['Captain'] ?></td>
            </tr>


        <?php } ?>
    </table>
    <?php
} elseif ($mode == 'list_players') {
    $team = 0;
    if (isset($_REQUEST['team']))
        $team = $_REQUEST['team'];
    ?>
    <h1>List of players on team</h1>
    <form method="get">
        <select name="team">
            <?php
            $result = $conn->query("SELECT * FROM teams;");
            foreach ($result as $row) {
                ?>
                <option value="<?= $row['id'] ?>"<?php
                # This selects the current team we're looking at, if any
                if ($team == $row['id']) {
                    echo " selected";
                }
                ?>><?= $row['name'] ?></option>
                <?php
            }
            ?>
        </select>
        <input type="hidden" value="list_players" name="mode"/>
        <input type="submit" value="Submit"/>
    </form>
    <?php
    if ($team) {
        $query = $conn->prepare("SELECT * FROM players WHERE team = ? ;");
        $query->bind_param("i", $team);
        $query->execute();
        $result = $query->get_result();
        ?>
        <table>
        <?php
        foreach ($result as $row) {
            ?>
            <tr>
                <td><?php echo $row['name'] ?></td>
            </tr>
            <?php
        }
    }
    ?>
    </table>
    <?php
} elseif ($mode == 'show_player') {
    $player = 0;
    if (isset($_REQUEST['player']))
        $player = $_REQUEST['player'];
    ?>
    <h1>Individual player details</h1>
    <form method="get">
        <select name="player">
            <?php
            $result = $conn->query("SELECT * FROM players;");
            foreach ($result as $row) {
                ?>
                <option value="<?= $row['id'] ?>"<?php
                # This selects the current player we're looking at, if any
                if ($player == $row['id']) {
                    echo " selected";
                }
                ?>><?= $row['name'] ?></option>
                <?php
            }
            ?>
        </select>
        <input type="hidden" value="show_player" name="mode"/>
        <input type="submit" value="Submit"/>
    </form>
    <?php
    if ($player) {
        $query = $conn->prepare("select players.id as ID, players.name as NAME, players.height as HEIGHT, players.hometown as HOMETOWN, players.team as TEAM, teams.name as Team, group_concat(position separator ', ') as positions from players, player_positions, teams where player_id = players.id and teams.id = players.team and players.id = ? group by player_id;");
        $query->bind_param("i", $player);
        $query->execute();
        $result = $query->get_result();
        ?>
        <table>
        <?php
        foreach ($result as $row) {
            ?>
            <tr>
                <td><?php echo $row['ID'] ?></td>
                <td><?php echo $row['NAME'] ?></td>
                <td><?php echo $row['HEIGHT'] ?></td>
                <td><?php echo $row['HOMETOWN'] ?></td>
                <td><?php echo $row['Team'] ?></td>
                <td><?php echo $row ['positions'] ?></td>
            </tr>
            <?php
        }
    }
    ?>
    </table>
    <?php
}
else if ($mode == 'list_positions') {
    $team = 0;
    $position = 0;
    if (isset($_REQUEST['team']))
        $team = $_REQUEST['team'];
    if (isset($_REQUEST['position']))
        $position = $_REQUEST['position'];
    ?>
    <h1>List of players on team by position</h1>
    <form method="get">
        <select name="team">
            <?php
            $result = $conn->query("SELECT * FROM teams;");
            foreach ($result as $row) {
                ?>
                <option value="<?=$row['id']?>"<?php
                # This selects the current team we're looking at, if any
                if ($team == $row['id']) {echo " selected";}
                ?>><?=$row['name']?></option>
                <?php
            }
            ?>
        </select>
        <input type="hidden" value="list_players" name="mode" />

        <select name="position">
            <?php
            $result = $conn->query("SELECT DISTINCT position FROM player_positions;"); //need to redirect to make not double up
            foreach ($result as $row) {
                ?>
                <option value="<?=$row['position']?>"<?php
                # This selects the list of positions we're looking at, if any
                if ($position == $row['position']) {echo " selected";}
                ?>><?=$row['position']?></option>
                <?php
            }
            ?>
        </select>
        <input type="hidden" value="list_positions" name="mode" />
        <input type="submit" value="Submit" />
    </form>
    <?php

    if ($team && $position) {

        $query = $conn->prepare(" select p.name from players p, player_positions ps, teams t
		                                                    where p.team = t.id and ps.player_id = p.id
		                                                    and t.id = ? and ps.position = ?");
        $query->bind_param("is", $team, $position);
        $query->execute();
        $result = $query->get_result();
        ?>
        <table>
        <?php
        foreach ($result as $row) {
            ?>
            <tr><td><?php echo $row['name']?></td></tr>
            <?php
        }
    }

    ?>
    </table>
    <?php
}
else {
    print "Mode '$mode' is not implemented yet.\n";
    print "Add another branch of the 'if' to complete it.";
}
?>
</body>
</html>