<?php
    require __DIR__ . '/../utilities/DbHelper.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    try {
        $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

        $username = $_SESSION["username"];
        $poolId = $_GET['poolId'];

        // Retrieve pool details
        $pools = $db->findBy(['pool_id' => $poolId], ['pool_id' => 'i'], null, null, Tables::Pools)[0];
        $options = $db->findBy(['pool_id' => $poolId], ['pool_id' => 'i'], null, null, Tables::Options);
        $userChoice = $db->complexQuery("SELECT * 
                                        FROM option_choices AS oc 
                                        INNER JOIN options AS o ON oc.option_id = o.option_id 
                                        WHERE oc.username = ? AND o.pool_id = ?;
                                        ", [$username, $poolId], ['s', 'i']);

        if (count($userChoice) > 0) {
            $userChoice = $userChoice[0];
        }

        if (count($pools) > 0) {
            $poolTitle = $pools['title'];
            $poolContent = $pools['content'];
            $expireDatetime = $pools['expire_datetime'];
        } else {
            throw new Exception("Pool not found.");
        }
        
        $userChosenOption = null;
        if (count($userChoice) > 0) {
            $userChosenOption = $userChoice['option_id'];
        }

        $userChosenOption = $userChoice;

        // Retrieve the vote count for each option
        $optionsWithVotes = [];
        foreach ($options as $option) {
            $optionId = $option['option_id'];
            $voteCount = $db->complexQuery("SELECT COUNT(*) as vote_count FROM option_choices WHERE option_id = ?", [$optionId], ['i'])[0]['vote_count'];
            $option['vote_count'] = $voteCount;
            $optionsWithVotes[] = $option;
        }

        echo json_encode([
            'poolId' => $poolId,
            'poolTitle' => $poolTitle,
            'poolContent' => $poolContent,
            'expireDatetime' => $expireDatetime,
            'options' => $optionsWithVotes,
            'userChosenOption' => $userChosenOption
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }

    $db->disconnect();
    $db = null;    
?>