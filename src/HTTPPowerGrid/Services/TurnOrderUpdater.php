<?php

namespace HTTPPowerGrid\Services;

class TurnOrderUpdater extends \PowerGrid\Abstracts\TurnOrderUpdater {

  public function newOrder() {
    $con = Propel::getWriteConnection(\Map\PlayerTableMap::DATABASE_NAME);

    // Get the players ranked first by number of cities, and then by the 
    // highest power plant value.
    $sql = '
      SELECT city_counts.player_id AS player_id, city_counts.city_count AS city_count, MAX(starting_auction_price) AS most_expensive_card

      FROM player AS p
      JOIN
        (
          SELECT player_id AS player_id, COUNT(1) AS city_count
            FROM player AS p
            JOIN player_city AS pc ON (p.id = pc.player_id)
            GROUP BY (p.id)
        ) AS city_counts
      ON (p.id = city_counts.player_id)
      JOIN
        player_card AS pcd
      ON (counts.player_id = pcd.player_id)
      JOIN
        game_card AS gc
      ON (pcd.card_id = gc.id)
      JOIN
        card AS c
      ON (gc.card_id = c.id)
        
      GROUP BY city_counts.player_id, city_counts.city_count
      ORDER BY city_counts.city_count, starting_auction_price DESC

    ';

    $rank = 1;
    foreach ($con->query($sql) AS $resultRow) {
      $playerId = $resultRow['player_id'];

      $turnOrder = new \TurnOrder();
      $turnOrder->setRank($rank);
      $turnOrder->setGame($this->game);
      $turnOrder->setPlayerId($playerId);
      $turnOrder->setRoundNumber($this->game->getRoundNumber());
      $turnOrder->setHasActed(FALSE);

      $turnOrder->save();

      ++$rank;
    }
  }

}
