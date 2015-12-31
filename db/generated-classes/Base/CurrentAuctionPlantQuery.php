<?php

namespace Base;

use \CurrentAuctionPlant as ChildCurrentAuctionPlant;
use \CurrentAuctionPlantQuery as ChildCurrentAuctionPlantQuery;
use \Exception;
use \PDO;
use Map\CurrentAuctionPlantTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'current_auction_plant' table.
 *
 *
 *
 * @method     ChildCurrentAuctionPlantQuery orderByGameId($order = Criteria::ASC) Order by the game_id column
 * @method     ChildCurrentAuctionPlantQuery orderByCardId($order = Criteria::ASC) Order by the card_id column
 * @method     ChildCurrentAuctionPlantQuery orderByHighestBid($order = Criteria::ASC) Order by the highest_bid column
 * @method     ChildCurrentAuctionPlantQuery orderByHighestBidderId($order = Criteria::ASC) Order by the highest_bidder_id column
 * @method     ChildCurrentAuctionPlantQuery orderByRoundNumber($order = Criteria::ASC) Order by the round_number column
 *
 * @method     ChildCurrentAuctionPlantQuery groupByGameId() Group by the game_id column
 * @method     ChildCurrentAuctionPlantQuery groupByCardId() Group by the card_id column
 * @method     ChildCurrentAuctionPlantQuery groupByHighestBid() Group by the highest_bid column
 * @method     ChildCurrentAuctionPlantQuery groupByHighestBidderId() Group by the highest_bidder_id column
 * @method     ChildCurrentAuctionPlantQuery groupByRoundNumber() Group by the round_number column
 *
 * @method     ChildCurrentAuctionPlantQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCurrentAuctionPlantQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCurrentAuctionPlantQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCurrentAuctionPlantQuery leftJoinGame($relationAlias = null) Adds a LEFT JOIN clause to the query using the Game relation
 * @method     ChildCurrentAuctionPlantQuery rightJoinGame($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Game relation
 * @method     ChildCurrentAuctionPlantQuery innerJoinGame($relationAlias = null) Adds a INNER JOIN clause to the query using the Game relation
 *
 * @method     ChildCurrentAuctionPlantQuery leftJoinCard($relationAlias = null) Adds a LEFT JOIN clause to the query using the Card relation
 * @method     ChildCurrentAuctionPlantQuery rightJoinCard($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Card relation
 * @method     ChildCurrentAuctionPlantQuery innerJoinCard($relationAlias = null) Adds a INNER JOIN clause to the query using the Card relation
 *
 * @method     ChildCurrentAuctionPlantQuery leftJoinHighestBidder($relationAlias = null) Adds a LEFT JOIN clause to the query using the HighestBidder relation
 * @method     ChildCurrentAuctionPlantQuery rightJoinHighestBidder($relationAlias = null) Adds a RIGHT JOIN clause to the query using the HighestBidder relation
 * @method     ChildCurrentAuctionPlantQuery innerJoinHighestBidder($relationAlias = null) Adds a INNER JOIN clause to the query using the HighestBidder relation
 *
 * @method     \GameQuery|\GameAuctionCardQuery|\PlayerQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCurrentAuctionPlant findOne(ConnectionInterface $con = null) Return the first ChildCurrentAuctionPlant matching the query
 * @method     ChildCurrentAuctionPlant findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCurrentAuctionPlant matching the query, or a new ChildCurrentAuctionPlant object populated from the query conditions when no match is found
 *
 * @method     ChildCurrentAuctionPlant findOneByGameId(int $game_id) Return the first ChildCurrentAuctionPlant filtered by the game_id column
 * @method     ChildCurrentAuctionPlant findOneByCardId(int $card_id) Return the first ChildCurrentAuctionPlant filtered by the card_id column
 * @method     ChildCurrentAuctionPlant findOneByHighestBid(int $highest_bid) Return the first ChildCurrentAuctionPlant filtered by the highest_bid column
 * @method     ChildCurrentAuctionPlant findOneByHighestBidderId(int $highest_bidder_id) Return the first ChildCurrentAuctionPlant filtered by the highest_bidder_id column
 * @method     ChildCurrentAuctionPlant findOneByRoundNumber(int $round_number) Return the first ChildCurrentAuctionPlant filtered by the round_number column *

 * @method     ChildCurrentAuctionPlant requirePk($key, ConnectionInterface $con = null) Return the ChildCurrentAuctionPlant by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCurrentAuctionPlant requireOne(ConnectionInterface $con = null) Return the first ChildCurrentAuctionPlant matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCurrentAuctionPlant requireOneByGameId(int $game_id) Return the first ChildCurrentAuctionPlant filtered by the game_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCurrentAuctionPlant requireOneByCardId(int $card_id) Return the first ChildCurrentAuctionPlant filtered by the card_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCurrentAuctionPlant requireOneByHighestBid(int $highest_bid) Return the first ChildCurrentAuctionPlant filtered by the highest_bid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCurrentAuctionPlant requireOneByHighestBidderId(int $highest_bidder_id) Return the first ChildCurrentAuctionPlant filtered by the highest_bidder_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCurrentAuctionPlant requireOneByRoundNumber(int $round_number) Return the first ChildCurrentAuctionPlant filtered by the round_number column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCurrentAuctionPlant[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCurrentAuctionPlant objects based on current ModelCriteria
 * @method     ChildCurrentAuctionPlant[]|ObjectCollection findByGameId(int $game_id) Return ChildCurrentAuctionPlant objects filtered by the game_id column
 * @method     ChildCurrentAuctionPlant[]|ObjectCollection findByCardId(int $card_id) Return ChildCurrentAuctionPlant objects filtered by the card_id column
 * @method     ChildCurrentAuctionPlant[]|ObjectCollection findByHighestBid(int $highest_bid) Return ChildCurrentAuctionPlant objects filtered by the highest_bid column
 * @method     ChildCurrentAuctionPlant[]|ObjectCollection findByHighestBidderId(int $highest_bidder_id) Return ChildCurrentAuctionPlant objects filtered by the highest_bidder_id column
 * @method     ChildCurrentAuctionPlant[]|ObjectCollection findByRoundNumber(int $round_number) Return ChildCurrentAuctionPlant objects filtered by the round_number column
 * @method     ChildCurrentAuctionPlant[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CurrentAuctionPlantQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\CurrentAuctionPlantQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'powergrid', $modelName = '\\CurrentAuctionPlant', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCurrentAuctionPlantQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCurrentAuctionPlantQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCurrentAuctionPlantQuery) {
            return $criteria;
        }
        $query = new ChildCurrentAuctionPlantQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildCurrentAuctionPlant|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CurrentAuctionPlantTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CurrentAuctionPlantTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCurrentAuctionPlant A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT game_id, card_id, highest_bid, highest_bidder_id, round_number FROM current_auction_plant WHERE game_id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildCurrentAuctionPlant $obj */
            $obj = new ChildCurrentAuctionPlant();
            $obj->hydrate($row);
            CurrentAuctionPlantTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildCurrentAuctionPlant|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildCurrentAuctionPlantQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CurrentAuctionPlantTableMap::COL_GAME_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCurrentAuctionPlantQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CurrentAuctionPlantTableMap::COL_GAME_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the game_id column
     *
     * Example usage:
     * <code>
     * $query->filterByGameId(1234); // WHERE game_id = 1234
     * $query->filterByGameId(array(12, 34)); // WHERE game_id IN (12, 34)
     * $query->filterByGameId(array('min' => 12)); // WHERE game_id > 12
     * </code>
     *
     * @see       filterByGame()
     *
     * @param     mixed $gameId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCurrentAuctionPlantQuery The current query, for fluid interface
     */
    public function filterByGameId($gameId = null, $comparison = null)
    {
        if (is_array($gameId)) {
            $useMinMax = false;
            if (isset($gameId['min'])) {
                $this->addUsingAlias(CurrentAuctionPlantTableMap::COL_GAME_ID, $gameId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($gameId['max'])) {
                $this->addUsingAlias(CurrentAuctionPlantTableMap::COL_GAME_ID, $gameId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CurrentAuctionPlantTableMap::COL_GAME_ID, $gameId, $comparison);
    }

    /**
     * Filter the query on the card_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCardId(1234); // WHERE card_id = 1234
     * $query->filterByCardId(array(12, 34)); // WHERE card_id IN (12, 34)
     * $query->filterByCardId(array('min' => 12)); // WHERE card_id > 12
     * </code>
     *
     * @see       filterByCard()
     *
     * @param     mixed $cardId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCurrentAuctionPlantQuery The current query, for fluid interface
     */
    public function filterByCardId($cardId = null, $comparison = null)
    {
        if (is_array($cardId)) {
            $useMinMax = false;
            if (isset($cardId['min'])) {
                $this->addUsingAlias(CurrentAuctionPlantTableMap::COL_CARD_ID, $cardId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cardId['max'])) {
                $this->addUsingAlias(CurrentAuctionPlantTableMap::COL_CARD_ID, $cardId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CurrentAuctionPlantTableMap::COL_CARD_ID, $cardId, $comparison);
    }

    /**
     * Filter the query on the highest_bid column
     *
     * Example usage:
     * <code>
     * $query->filterByHighestBid(1234); // WHERE highest_bid = 1234
     * $query->filterByHighestBid(array(12, 34)); // WHERE highest_bid IN (12, 34)
     * $query->filterByHighestBid(array('min' => 12)); // WHERE highest_bid > 12
     * </code>
     *
     * @param     mixed $highestBid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCurrentAuctionPlantQuery The current query, for fluid interface
     */
    public function filterByHighestBid($highestBid = null, $comparison = null)
    {
        if (is_array($highestBid)) {
            $useMinMax = false;
            if (isset($highestBid['min'])) {
                $this->addUsingAlias(CurrentAuctionPlantTableMap::COL_HIGHEST_BID, $highestBid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($highestBid['max'])) {
                $this->addUsingAlias(CurrentAuctionPlantTableMap::COL_HIGHEST_BID, $highestBid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CurrentAuctionPlantTableMap::COL_HIGHEST_BID, $highestBid, $comparison);
    }

    /**
     * Filter the query on the highest_bidder_id column
     *
     * Example usage:
     * <code>
     * $query->filterByHighestBidderId(1234); // WHERE highest_bidder_id = 1234
     * $query->filterByHighestBidderId(array(12, 34)); // WHERE highest_bidder_id IN (12, 34)
     * $query->filterByHighestBidderId(array('min' => 12)); // WHERE highest_bidder_id > 12
     * </code>
     *
     * @see       filterByHighestBidder()
     *
     * @param     mixed $highestBidderId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCurrentAuctionPlantQuery The current query, for fluid interface
     */
    public function filterByHighestBidderId($highestBidderId = null, $comparison = null)
    {
        if (is_array($highestBidderId)) {
            $useMinMax = false;
            if (isset($highestBidderId['min'])) {
                $this->addUsingAlias(CurrentAuctionPlantTableMap::COL_HIGHEST_BIDDER_ID, $highestBidderId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($highestBidderId['max'])) {
                $this->addUsingAlias(CurrentAuctionPlantTableMap::COL_HIGHEST_BIDDER_ID, $highestBidderId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CurrentAuctionPlantTableMap::COL_HIGHEST_BIDDER_ID, $highestBidderId, $comparison);
    }

    /**
     * Filter the query on the round_number column
     *
     * Example usage:
     * <code>
     * $query->filterByRoundNumber(1234); // WHERE round_number = 1234
     * $query->filterByRoundNumber(array(12, 34)); // WHERE round_number IN (12, 34)
     * $query->filterByRoundNumber(array('min' => 12)); // WHERE round_number > 12
     * </code>
     *
     * @param     mixed $roundNumber The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCurrentAuctionPlantQuery The current query, for fluid interface
     */
    public function filterByRoundNumber($roundNumber = null, $comparison = null)
    {
        if (is_array($roundNumber)) {
            $useMinMax = false;
            if (isset($roundNumber['min'])) {
                $this->addUsingAlias(CurrentAuctionPlantTableMap::COL_ROUND_NUMBER, $roundNumber['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($roundNumber['max'])) {
                $this->addUsingAlias(CurrentAuctionPlantTableMap::COL_ROUND_NUMBER, $roundNumber['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CurrentAuctionPlantTableMap::COL_ROUND_NUMBER, $roundNumber, $comparison);
    }

    /**
     * Filter the query by a related \Game object
     *
     * @param \Game|ObjectCollection $game The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCurrentAuctionPlantQuery The current query, for fluid interface
     */
    public function filterByGame($game, $comparison = null)
    {
        if ($game instanceof \Game) {
            return $this
                ->addUsingAlias(CurrentAuctionPlantTableMap::COL_GAME_ID, $game->getId(), $comparison);
        } elseif ($game instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CurrentAuctionPlantTableMap::COL_GAME_ID, $game->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByGame() only accepts arguments of type \Game or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Game relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCurrentAuctionPlantQuery The current query, for fluid interface
     */
    public function joinGame($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Game');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Game');
        }

        return $this;
    }

    /**
     * Use the Game relation Game object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GameQuery A secondary query class using the current class as primary query
     */
    public function useGameQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGame($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Game', '\GameQuery');
    }

    /**
     * Filter the query by a related \GameAuctionCard object
     *
     * @param \GameAuctionCard|ObjectCollection $gameAuctionCard The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCurrentAuctionPlantQuery The current query, for fluid interface
     */
    public function filterByCard($gameAuctionCard, $comparison = null)
    {
        if ($gameAuctionCard instanceof \GameAuctionCard) {
            return $this
                ->addUsingAlias(CurrentAuctionPlantTableMap::COL_CARD_ID, $gameAuctionCard->getId(), $comparison);
        } elseif ($gameAuctionCard instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CurrentAuctionPlantTableMap::COL_CARD_ID, $gameAuctionCard->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCard() only accepts arguments of type \GameAuctionCard or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Card relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCurrentAuctionPlantQuery The current query, for fluid interface
     */
    public function joinCard($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Card');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Card');
        }

        return $this;
    }

    /**
     * Use the Card relation GameAuctionCard object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GameAuctionCardQuery A secondary query class using the current class as primary query
     */
    public function useCardQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCard($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Card', '\GameAuctionCardQuery');
    }

    /**
     * Filter the query by a related \Player object
     *
     * @param \Player|ObjectCollection $player The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCurrentAuctionPlantQuery The current query, for fluid interface
     */
    public function filterByHighestBidder($player, $comparison = null)
    {
        if ($player instanceof \Player) {
            return $this
                ->addUsingAlias(CurrentAuctionPlantTableMap::COL_HIGHEST_BIDDER_ID, $player->getId(), $comparison);
        } elseif ($player instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CurrentAuctionPlantTableMap::COL_HIGHEST_BIDDER_ID, $player->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByHighestBidder() only accepts arguments of type \Player or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the HighestBidder relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCurrentAuctionPlantQuery The current query, for fluid interface
     */
    public function joinHighestBidder($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('HighestBidder');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'HighestBidder');
        }

        return $this;
    }

    /**
     * Use the HighestBidder relation Player object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PlayerQuery A secondary query class using the current class as primary query
     */
    public function useHighestBidderQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinHighestBidder($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'HighestBidder', '\PlayerQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCurrentAuctionPlant $currentAuctionPlant Object to remove from the list of results
     *
     * @return $this|ChildCurrentAuctionPlantQuery The current query, for fluid interface
     */
    public function prune($currentAuctionPlant = null)
    {
        if ($currentAuctionPlant) {
            $this->addUsingAlias(CurrentAuctionPlantTableMap::COL_GAME_ID, $currentAuctionPlant->getGameId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the current_auction_plant table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CurrentAuctionPlantTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CurrentAuctionPlantTableMap::clearInstancePool();
            CurrentAuctionPlantTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CurrentAuctionPlantTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CurrentAuctionPlantTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CurrentAuctionPlantTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CurrentAuctionPlantTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CurrentAuctionPlantQuery
