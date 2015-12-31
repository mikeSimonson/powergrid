<?php

namespace Base;

use \TurnOrder as ChildTurnOrder;
use \TurnOrderQuery as ChildTurnOrderQuery;
use \Exception;
use \PDO;
use Map\TurnOrderTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'turn_order' table.
 *
 *
 *
 * @method     ChildTurnOrderQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildTurnOrderQuery orderByRank($order = Criteria::ASC) Order by the rank column
 * @method     ChildTurnOrderQuery orderByGameId($order = Criteria::ASC) Order by the game_id column
 * @method     ChildTurnOrderQuery orderByPlayerId($order = Criteria::ASC) Order by the player_id column
 * @method     ChildTurnOrderQuery orderByRoundNumber($order = Criteria::ASC) Order by the round_number column
 * @method     ChildTurnOrderQuery orderByPhaseNumber($order = Criteria::ASC) Order by the phase_number column
 * @method     ChildTurnOrderQuery orderByHasActed($order = Criteria::ASC) Order by the has_acted column
 *
 * @method     ChildTurnOrderQuery groupById() Group by the id column
 * @method     ChildTurnOrderQuery groupByRank() Group by the rank column
 * @method     ChildTurnOrderQuery groupByGameId() Group by the game_id column
 * @method     ChildTurnOrderQuery groupByPlayerId() Group by the player_id column
 * @method     ChildTurnOrderQuery groupByRoundNumber() Group by the round_number column
 * @method     ChildTurnOrderQuery groupByPhaseNumber() Group by the phase_number column
 * @method     ChildTurnOrderQuery groupByHasActed() Group by the has_acted column
 *
 * @method     ChildTurnOrderQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTurnOrderQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTurnOrderQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTurnOrderQuery leftJoinGame($relationAlias = null) Adds a LEFT JOIN clause to the query using the Game relation
 * @method     ChildTurnOrderQuery rightJoinGame($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Game relation
 * @method     ChildTurnOrderQuery innerJoinGame($relationAlias = null) Adds a INNER JOIN clause to the query using the Game relation
 *
 * @method     ChildTurnOrderQuery leftJoinPlayer($relationAlias = null) Adds a LEFT JOIN clause to the query using the Player relation
 * @method     ChildTurnOrderQuery rightJoinPlayer($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Player relation
 * @method     ChildTurnOrderQuery innerJoinPlayer($relationAlias = null) Adds a INNER JOIN clause to the query using the Player relation
 *
 * @method     \GameQuery|\PlayerQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTurnOrder findOne(ConnectionInterface $con = null) Return the first ChildTurnOrder matching the query
 * @method     ChildTurnOrder findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTurnOrder matching the query, or a new ChildTurnOrder object populated from the query conditions when no match is found
 *
 * @method     ChildTurnOrder findOneById(int $id) Return the first ChildTurnOrder filtered by the id column
 * @method     ChildTurnOrder findOneByRank(int $rank) Return the first ChildTurnOrder filtered by the rank column
 * @method     ChildTurnOrder findOneByGameId(int $game_id) Return the first ChildTurnOrder filtered by the game_id column
 * @method     ChildTurnOrder findOneByPlayerId(int $player_id) Return the first ChildTurnOrder filtered by the player_id column
 * @method     ChildTurnOrder findOneByRoundNumber(int $round_number) Return the first ChildTurnOrder filtered by the round_number column
 * @method     ChildTurnOrder findOneByPhaseNumber(int $phase_number) Return the first ChildTurnOrder filtered by the phase_number column
 * @method     ChildTurnOrder findOneByHasActed(boolean $has_acted) Return the first ChildTurnOrder filtered by the has_acted column *

 * @method     ChildTurnOrder requirePk($key, ConnectionInterface $con = null) Return the ChildTurnOrder by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTurnOrder requireOne(ConnectionInterface $con = null) Return the first ChildTurnOrder matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTurnOrder requireOneById(int $id) Return the first ChildTurnOrder filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTurnOrder requireOneByRank(int $rank) Return the first ChildTurnOrder filtered by the rank column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTurnOrder requireOneByGameId(int $game_id) Return the first ChildTurnOrder filtered by the game_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTurnOrder requireOneByPlayerId(int $player_id) Return the first ChildTurnOrder filtered by the player_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTurnOrder requireOneByRoundNumber(int $round_number) Return the first ChildTurnOrder filtered by the round_number column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTurnOrder requireOneByPhaseNumber(int $phase_number) Return the first ChildTurnOrder filtered by the phase_number column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTurnOrder requireOneByHasActed(boolean $has_acted) Return the first ChildTurnOrder filtered by the has_acted column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTurnOrder[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTurnOrder objects based on current ModelCriteria
 * @method     ChildTurnOrder[]|ObjectCollection findById(int $id) Return ChildTurnOrder objects filtered by the id column
 * @method     ChildTurnOrder[]|ObjectCollection findByRank(int $rank) Return ChildTurnOrder objects filtered by the rank column
 * @method     ChildTurnOrder[]|ObjectCollection findByGameId(int $game_id) Return ChildTurnOrder objects filtered by the game_id column
 * @method     ChildTurnOrder[]|ObjectCollection findByPlayerId(int $player_id) Return ChildTurnOrder objects filtered by the player_id column
 * @method     ChildTurnOrder[]|ObjectCollection findByRoundNumber(int $round_number) Return ChildTurnOrder objects filtered by the round_number column
 * @method     ChildTurnOrder[]|ObjectCollection findByPhaseNumber(int $phase_number) Return ChildTurnOrder objects filtered by the phase_number column
 * @method     ChildTurnOrder[]|ObjectCollection findByHasActed(boolean $has_acted) Return ChildTurnOrder objects filtered by the has_acted column
 * @method     ChildTurnOrder[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TurnOrderQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\TurnOrderQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'powergrid', $modelName = '\\TurnOrder', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTurnOrderQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTurnOrderQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTurnOrderQuery) {
            return $criteria;
        }
        $query = new ChildTurnOrderQuery();
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
     * @return ChildTurnOrder|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TurnOrderTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TurnOrderTableMap::DATABASE_NAME);
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
     * @return ChildTurnOrder A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, rank, game_id, player_id, round_number, phase_number, has_acted FROM turn_order WHERE id = :p0';
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
            /** @var ChildTurnOrder $obj */
            $obj = new ChildTurnOrder();
            $obj->hydrate($row);
            TurnOrderTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildTurnOrder|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTurnOrderQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TurnOrderTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTurnOrderQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TurnOrderTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTurnOrderQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TurnOrderTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TurnOrderTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TurnOrderTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the rank column
     *
     * Example usage:
     * <code>
     * $query->filterByRank(1234); // WHERE rank = 1234
     * $query->filterByRank(array(12, 34)); // WHERE rank IN (12, 34)
     * $query->filterByRank(array('min' => 12)); // WHERE rank > 12
     * </code>
     *
     * @param     mixed $rank The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTurnOrderQuery The current query, for fluid interface
     */
    public function filterByRank($rank = null, $comparison = null)
    {
        if (is_array($rank)) {
            $useMinMax = false;
            if (isset($rank['min'])) {
                $this->addUsingAlias(TurnOrderTableMap::COL_RANK, $rank['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rank['max'])) {
                $this->addUsingAlias(TurnOrderTableMap::COL_RANK, $rank['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TurnOrderTableMap::COL_RANK, $rank, $comparison);
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
     * @return $this|ChildTurnOrderQuery The current query, for fluid interface
     */
    public function filterByGameId($gameId = null, $comparison = null)
    {
        if (is_array($gameId)) {
            $useMinMax = false;
            if (isset($gameId['min'])) {
                $this->addUsingAlias(TurnOrderTableMap::COL_GAME_ID, $gameId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($gameId['max'])) {
                $this->addUsingAlias(TurnOrderTableMap::COL_GAME_ID, $gameId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TurnOrderTableMap::COL_GAME_ID, $gameId, $comparison);
    }

    /**
     * Filter the query on the player_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPlayerId(1234); // WHERE player_id = 1234
     * $query->filterByPlayerId(array(12, 34)); // WHERE player_id IN (12, 34)
     * $query->filterByPlayerId(array('min' => 12)); // WHERE player_id > 12
     * </code>
     *
     * @see       filterByPlayer()
     *
     * @param     mixed $playerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTurnOrderQuery The current query, for fluid interface
     */
    public function filterByPlayerId($playerId = null, $comparison = null)
    {
        if (is_array($playerId)) {
            $useMinMax = false;
            if (isset($playerId['min'])) {
                $this->addUsingAlias(TurnOrderTableMap::COL_PLAYER_ID, $playerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($playerId['max'])) {
                $this->addUsingAlias(TurnOrderTableMap::COL_PLAYER_ID, $playerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TurnOrderTableMap::COL_PLAYER_ID, $playerId, $comparison);
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
     * @return $this|ChildTurnOrderQuery The current query, for fluid interface
     */
    public function filterByRoundNumber($roundNumber = null, $comparison = null)
    {
        if (is_array($roundNumber)) {
            $useMinMax = false;
            if (isset($roundNumber['min'])) {
                $this->addUsingAlias(TurnOrderTableMap::COL_ROUND_NUMBER, $roundNumber['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($roundNumber['max'])) {
                $this->addUsingAlias(TurnOrderTableMap::COL_ROUND_NUMBER, $roundNumber['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TurnOrderTableMap::COL_ROUND_NUMBER, $roundNumber, $comparison);
    }

    /**
     * Filter the query on the phase_number column
     *
     * Example usage:
     * <code>
     * $query->filterByPhaseNumber(1234); // WHERE phase_number = 1234
     * $query->filterByPhaseNumber(array(12, 34)); // WHERE phase_number IN (12, 34)
     * $query->filterByPhaseNumber(array('min' => 12)); // WHERE phase_number > 12
     * </code>
     *
     * @param     mixed $phaseNumber The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTurnOrderQuery The current query, for fluid interface
     */
    public function filterByPhaseNumber($phaseNumber = null, $comparison = null)
    {
        if (is_array($phaseNumber)) {
            $useMinMax = false;
            if (isset($phaseNumber['min'])) {
                $this->addUsingAlias(TurnOrderTableMap::COL_PHASE_NUMBER, $phaseNumber['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($phaseNumber['max'])) {
                $this->addUsingAlias(TurnOrderTableMap::COL_PHASE_NUMBER, $phaseNumber['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TurnOrderTableMap::COL_PHASE_NUMBER, $phaseNumber, $comparison);
    }

    /**
     * Filter the query on the has_acted column
     *
     * Example usage:
     * <code>
     * $query->filterByHasActed(true); // WHERE has_acted = true
     * $query->filterByHasActed('yes'); // WHERE has_acted = true
     * </code>
     *
     * @param     boolean|string $hasActed The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTurnOrderQuery The current query, for fluid interface
     */
    public function filterByHasActed($hasActed = null, $comparison = null)
    {
        if (is_string($hasActed)) {
            $hasActed = in_array(strtolower($hasActed), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(TurnOrderTableMap::COL_HAS_ACTED, $hasActed, $comparison);
    }

    /**
     * Filter the query by a related \Game object
     *
     * @param \Game|ObjectCollection $game The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTurnOrderQuery The current query, for fluid interface
     */
    public function filterByGame($game, $comparison = null)
    {
        if ($game instanceof \Game) {
            return $this
                ->addUsingAlias(TurnOrderTableMap::COL_GAME_ID, $game->getId(), $comparison);
        } elseif ($game instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TurnOrderTableMap::COL_GAME_ID, $game->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildTurnOrderQuery The current query, for fluid interface
     */
    public function joinGame($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useGameQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinGame($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Game', '\GameQuery');
    }

    /**
     * Filter the query by a related \Player object
     *
     * @param \Player|ObjectCollection $player The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTurnOrderQuery The current query, for fluid interface
     */
    public function filterByPlayer($player, $comparison = null)
    {
        if ($player instanceof \Player) {
            return $this
                ->addUsingAlias(TurnOrderTableMap::COL_PLAYER_ID, $player->getId(), $comparison);
        } elseif ($player instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TurnOrderTableMap::COL_PLAYER_ID, $player->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPlayer() only accepts arguments of type \Player or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Player relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTurnOrderQuery The current query, for fluid interface
     */
    public function joinPlayer($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Player');

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
            $this->addJoinObject($join, 'Player');
        }

        return $this;
    }

    /**
     * Use the Player relation Player object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PlayerQuery A secondary query class using the current class as primary query
     */
    public function usePlayerQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPlayer($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Player', '\PlayerQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTurnOrder $turnOrder Object to remove from the list of results
     *
     * @return $this|ChildTurnOrderQuery The current query, for fluid interface
     */
    public function prune($turnOrder = null)
    {
        if ($turnOrder) {
            $this->addUsingAlias(TurnOrderTableMap::COL_ID, $turnOrder->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the turn_order table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TurnOrderTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TurnOrderTableMap::clearInstancePool();
            TurnOrderTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TurnOrderTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TurnOrderTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TurnOrderTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TurnOrderTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TurnOrderQuery
