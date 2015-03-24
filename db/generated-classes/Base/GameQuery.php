<?php

namespace Base;

use \Game as ChildGame;
use \GameQuery as ChildGameQuery;
use \Exception;
use \PDO;
use Map\GameTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'game' table.
 *
 *
 *
 * @method     ChildGameQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildGameQuery orderByTurnNumber($order = Criteria::ASC) Order by the turn_number column
 * @method     ChildGameQuery orderByStepNumber($order = Criteria::ASC) Order by the step_number column
 * @method     ChildGameQuery orderByNextPlayerId($order = Criteria::ASC) Order by the next_player_id column
 * @method     ChildGameQuery orderByOwnerId($order = Criteria::ASC) Order by the owner_id column
 * @method     ChildGameQuery orderByBankId($order = Criteria::ASC) Order by the bank_id column
 * @method     ChildGameQuery orderByMapId($order = Criteria::ASC) Order by the map_id column
 *
 * @method     ChildGameQuery groupById() Group by the id column
 * @method     ChildGameQuery groupByTurnNumber() Group by the turn_number column
 * @method     ChildGameQuery groupByStepNumber() Group by the step_number column
 * @method     ChildGameQuery groupByNextPlayerId() Group by the next_player_id column
 * @method     ChildGameQuery groupByOwnerId() Group by the owner_id column
 * @method     ChildGameQuery groupByBankId() Group by the bank_id column
 * @method     ChildGameQuery groupByMapId() Group by the map_id column
 *
 * @method     ChildGameQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildGameQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildGameQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildGameQuery leftJoinPlayer($relationAlias = null) Adds a LEFT JOIN clause to the query using the Player relation
 * @method     ChildGameQuery rightJoinPlayer($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Player relation
 * @method     ChildGameQuery innerJoinPlayer($relationAlias = null) Adds a INNER JOIN clause to the query using the Player relation
 *
 * @method     ChildGameQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildGameQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildGameQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildGameQuery leftJoinBank($relationAlias = null) Adds a LEFT JOIN clause to the query using the Bank relation
 * @method     ChildGameQuery rightJoinBank($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Bank relation
 * @method     ChildGameQuery innerJoinBank($relationAlias = null) Adds a INNER JOIN clause to the query using the Bank relation
 *
 * @method     ChildGameQuery leftJoinMap($relationAlias = null) Adds a LEFT JOIN clause to the query using the Map relation
 * @method     ChildGameQuery rightJoinMap($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Map relation
 * @method     ChildGameQuery innerJoinMap($relationAlias = null) Adds a INNER JOIN clause to the query using the Map relation
 *
 * @method     ChildGameQuery leftJoinPlayer($relationAlias = null) Adds a LEFT JOIN clause to the query using the Player relation
 * @method     ChildGameQuery rightJoinPlayer($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Player relation
 * @method     ChildGameQuery innerJoinPlayer($relationAlias = null) Adds a INNER JOIN clause to the query using the Player relation
 *
 * @method     ChildGameQuery leftJoinResourceStore($relationAlias = null) Adds a LEFT JOIN clause to the query using the ResourceStore relation
 * @method     ChildGameQuery rightJoinResourceStore($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ResourceStore relation
 * @method     ChildGameQuery innerJoinResourceStore($relationAlias = null) Adds a INNER JOIN clause to the query using the ResourceStore relation
 *
 * @method     ChildGameQuery leftJoinTurnOrder($relationAlias = null) Adds a LEFT JOIN clause to the query using the TurnOrder relation
 * @method     ChildGameQuery rightJoinTurnOrder($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TurnOrder relation
 * @method     ChildGameQuery innerJoinTurnOrder($relationAlias = null) Adds a INNER JOIN clause to the query using the TurnOrder relation
 *
 * @method     ChildGameQuery leftJoinGameCard($relationAlias = null) Adds a LEFT JOIN clause to the query using the GameCard relation
 * @method     ChildGameQuery rightJoinGameCard($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GameCard relation
 * @method     ChildGameQuery innerJoinGameCard($relationAlias = null) Adds a INNER JOIN clause to the query using the GameCard relation
 *
 * @method     ChildGameQuery leftJoinGameCity($relationAlias = null) Adds a LEFT JOIN clause to the query using the GameCity relation
 * @method     ChildGameQuery rightJoinGameCity($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GameCity relation
 * @method     ChildGameQuery innerJoinGameCity($relationAlias = null) Adds a INNER JOIN clause to the query using the GameCity relation
 *
 * @method     \PlayerQuery|\UserQuery|\BankQuery|\MapQuery|\ResourceStoreQuery|\TurnOrderQuery|\GameCardQuery|\GameCityQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildGame findOne(ConnectionInterface $con = null) Return the first ChildGame matching the query
 * @method     ChildGame findOneOrCreate(ConnectionInterface $con = null) Return the first ChildGame matching the query, or a new ChildGame object populated from the query conditions when no match is found
 *
 * @method     ChildGame findOneById(int $id) Return the first ChildGame filtered by the id column
 * @method     ChildGame findOneByTurnNumber(int $turn_number) Return the first ChildGame filtered by the turn_number column
 * @method     ChildGame findOneByStepNumber(int $step_number) Return the first ChildGame filtered by the step_number column
 * @method     ChildGame findOneByNextPlayerId(int $next_player_id) Return the first ChildGame filtered by the next_player_id column
 * @method     ChildGame findOneByOwnerId(int $owner_id) Return the first ChildGame filtered by the owner_id column
 * @method     ChildGame findOneByBankId(int $bank_id) Return the first ChildGame filtered by the bank_id column
 * @method     ChildGame findOneByMapId(int $map_id) Return the first ChildGame filtered by the map_id column *

 * @method     ChildGame requirePk($key, ConnectionInterface $con = null) Return the ChildGame by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGame requireOne(ConnectionInterface $con = null) Return the first ChildGame matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGame requireOneById(int $id) Return the first ChildGame filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGame requireOneByTurnNumber(int $turn_number) Return the first ChildGame filtered by the turn_number column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGame requireOneByStepNumber(int $step_number) Return the first ChildGame filtered by the step_number column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGame requireOneByNextPlayerId(int $next_player_id) Return the first ChildGame filtered by the next_player_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGame requireOneByOwnerId(int $owner_id) Return the first ChildGame filtered by the owner_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGame requireOneByBankId(int $bank_id) Return the first ChildGame filtered by the bank_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGame requireOneByMapId(int $map_id) Return the first ChildGame filtered by the map_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGame[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildGame objects based on current ModelCriteria
 * @method     ChildGame[]|ObjectCollection findById(int $id) Return ChildGame objects filtered by the id column
 * @method     ChildGame[]|ObjectCollection findByTurnNumber(int $turn_number) Return ChildGame objects filtered by the turn_number column
 * @method     ChildGame[]|ObjectCollection findByStepNumber(int $step_number) Return ChildGame objects filtered by the step_number column
 * @method     ChildGame[]|ObjectCollection findByNextPlayerId(int $next_player_id) Return ChildGame objects filtered by the next_player_id column
 * @method     ChildGame[]|ObjectCollection findByOwnerId(int $owner_id) Return ChildGame objects filtered by the owner_id column
 * @method     ChildGame[]|ObjectCollection findByBankId(int $bank_id) Return ChildGame objects filtered by the bank_id column
 * @method     ChildGame[]|ObjectCollection findByMapId(int $map_id) Return ChildGame objects filtered by the map_id column
 * @method     ChildGame[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class GameQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\GameQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'powergrid', $modelName = '\\Game', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildGameQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildGameQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildGameQuery) {
            return $criteria;
        }
        $query = new ChildGameQuery();
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
     * @return ChildGame|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = GameTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GameTableMap::DATABASE_NAME);
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
     * @return ChildGame A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, turn_number, step_number, next_player_id, owner_id, bank_id, map_id FROM game WHERE id = :p0';
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
            /** @var ChildGame $obj */
            $obj = new ChildGame();
            $obj->hydrate($row);
            GameTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildGame|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(GameTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(GameTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(GameTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(GameTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GameTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the turn_number column
     *
     * Example usage:
     * <code>
     * $query->filterByTurnNumber(1234); // WHERE turn_number = 1234
     * $query->filterByTurnNumber(array(12, 34)); // WHERE turn_number IN (12, 34)
     * $query->filterByTurnNumber(array('min' => 12)); // WHERE turn_number > 12
     * </code>
     *
     * @param     mixed $turnNumber The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function filterByTurnNumber($turnNumber = null, $comparison = null)
    {
        if (is_array($turnNumber)) {
            $useMinMax = false;
            if (isset($turnNumber['min'])) {
                $this->addUsingAlias(GameTableMap::COL_TURN_NUMBER, $turnNumber['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($turnNumber['max'])) {
                $this->addUsingAlias(GameTableMap::COL_TURN_NUMBER, $turnNumber['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GameTableMap::COL_TURN_NUMBER, $turnNumber, $comparison);
    }

    /**
     * Filter the query on the step_number column
     *
     * Example usage:
     * <code>
     * $query->filterByStepNumber(1234); // WHERE step_number = 1234
     * $query->filterByStepNumber(array(12, 34)); // WHERE step_number IN (12, 34)
     * $query->filterByStepNumber(array('min' => 12)); // WHERE step_number > 12
     * </code>
     *
     * @param     mixed $stepNumber The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function filterByStepNumber($stepNumber = null, $comparison = null)
    {
        if (is_array($stepNumber)) {
            $useMinMax = false;
            if (isset($stepNumber['min'])) {
                $this->addUsingAlias(GameTableMap::COL_STEP_NUMBER, $stepNumber['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($stepNumber['max'])) {
                $this->addUsingAlias(GameTableMap::COL_STEP_NUMBER, $stepNumber['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GameTableMap::COL_STEP_NUMBER, $stepNumber, $comparison);
    }

    /**
     * Filter the query on the next_player_id column
     *
     * Example usage:
     * <code>
     * $query->filterByNextPlayerId(1234); // WHERE next_player_id = 1234
     * $query->filterByNextPlayerId(array(12, 34)); // WHERE next_player_id IN (12, 34)
     * $query->filterByNextPlayerId(array('min' => 12)); // WHERE next_player_id > 12
     * </code>
     *
     * @see       filterByPlayer()
     *
     * @param     mixed $nextPlayerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function filterByNextPlayerId($nextPlayerId = null, $comparison = null)
    {
        if (is_array($nextPlayerId)) {
            $useMinMax = false;
            if (isset($nextPlayerId['min'])) {
                $this->addUsingAlias(GameTableMap::COL_NEXT_PLAYER_ID, $nextPlayerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($nextPlayerId['max'])) {
                $this->addUsingAlias(GameTableMap::COL_NEXT_PLAYER_ID, $nextPlayerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GameTableMap::COL_NEXT_PLAYER_ID, $nextPlayerId, $comparison);
    }

    /**
     * Filter the query on the owner_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOwnerId(1234); // WHERE owner_id = 1234
     * $query->filterByOwnerId(array(12, 34)); // WHERE owner_id IN (12, 34)
     * $query->filterByOwnerId(array('min' => 12)); // WHERE owner_id > 12
     * </code>
     *
     * @see       filterByUser()
     *
     * @param     mixed $ownerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function filterByOwnerId($ownerId = null, $comparison = null)
    {
        if (is_array($ownerId)) {
            $useMinMax = false;
            if (isset($ownerId['min'])) {
                $this->addUsingAlias(GameTableMap::COL_OWNER_ID, $ownerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($ownerId['max'])) {
                $this->addUsingAlias(GameTableMap::COL_OWNER_ID, $ownerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GameTableMap::COL_OWNER_ID, $ownerId, $comparison);
    }

    /**
     * Filter the query on the bank_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBankId(1234); // WHERE bank_id = 1234
     * $query->filterByBankId(array(12, 34)); // WHERE bank_id IN (12, 34)
     * $query->filterByBankId(array('min' => 12)); // WHERE bank_id > 12
     * </code>
     *
     * @see       filterByBank()
     *
     * @param     mixed $bankId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function filterByBankId($bankId = null, $comparison = null)
    {
        if (is_array($bankId)) {
            $useMinMax = false;
            if (isset($bankId['min'])) {
                $this->addUsingAlias(GameTableMap::COL_BANK_ID, $bankId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($bankId['max'])) {
                $this->addUsingAlias(GameTableMap::COL_BANK_ID, $bankId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GameTableMap::COL_BANK_ID, $bankId, $comparison);
    }

    /**
     * Filter the query on the map_id column
     *
     * Example usage:
     * <code>
     * $query->filterByMapId(1234); // WHERE map_id = 1234
     * $query->filterByMapId(array(12, 34)); // WHERE map_id IN (12, 34)
     * $query->filterByMapId(array('min' => 12)); // WHERE map_id > 12
     * </code>
     *
     * @see       filterByMap()
     *
     * @param     mixed $mapId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function filterByMapId($mapId = null, $comparison = null)
    {
        if (is_array($mapId)) {
            $useMinMax = false;
            if (isset($mapId['min'])) {
                $this->addUsingAlias(GameTableMap::COL_MAP_ID, $mapId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($mapId['max'])) {
                $this->addUsingAlias(GameTableMap::COL_MAP_ID, $mapId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GameTableMap::COL_MAP_ID, $mapId, $comparison);
    }

    /**
     * Filter the query by a related \Player object
     *
     * @param \Player|ObjectCollection $player The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGameQuery The current query, for fluid interface
     */
    public function filterByPlayer($player, $comparison = null)
    {
        if ($player instanceof \Player) {
            return $this
                ->addUsingAlias(GameTableMap::COL_NEXT_PLAYER_ID, $player->getId(), $comparison);
        } elseif ($player instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GameTableMap::COL_NEXT_PLAYER_ID, $player->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function joinPlayer($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function usePlayerQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPlayer($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Player', '\PlayerQuery');
    }

    /**
     * Filter the query by a related \User object
     *
     * @param \User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGameQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \User) {
            return $this
                ->addUsingAlias(GameTableMap::COL_OWNER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GameTableMap::COL_OWNER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type \User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

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
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\UserQuery');
    }

    /**
     * Filter the query by a related \Bank object
     *
     * @param \Bank|ObjectCollection $bank The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGameQuery The current query, for fluid interface
     */
    public function filterByBank($bank, $comparison = null)
    {
        if ($bank instanceof \Bank) {
            return $this
                ->addUsingAlias(GameTableMap::COL_BANK_ID, $bank->getId(), $comparison);
        } elseif ($bank instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GameTableMap::COL_BANK_ID, $bank->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByBank() only accepts arguments of type \Bank or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Bank relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function joinBank($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Bank');

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
            $this->addJoinObject($join, 'Bank');
        }

        return $this;
    }

    /**
     * Use the Bank relation Bank object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BankQuery A secondary query class using the current class as primary query
     */
    public function useBankQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBank($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Bank', '\BankQuery');
    }

    /**
     * Filter the query by a related \Map object
     *
     * @param \Map|ObjectCollection $map The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGameQuery The current query, for fluid interface
     */
    public function filterByMap($map, $comparison = null)
    {
        if ($map instanceof \Map) {
            return $this
                ->addUsingAlias(GameTableMap::COL_MAP_ID, $map->getId(), $comparison);
        } elseif ($map instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GameTableMap::COL_MAP_ID, $map->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByMap() only accepts arguments of type \Map or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Map relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function joinMap($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Map');

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
            $this->addJoinObject($join, 'Map');
        }

        return $this;
    }

    /**
     * Use the Map relation Map object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MapQuery A secondary query class using the current class as primary query
     */
    public function useMapQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMap($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Map', '\MapQuery');
    }

    /**
     * Filter the query by a related \Player object
     *
     * @param \Player|ObjectCollection $player the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGameQuery The current query, for fluid interface
     */
    public function filterByPlayer($player, $comparison = null)
    {
        if ($player instanceof \Player) {
            return $this
                ->addUsingAlias(GameTableMap::COL_ID, $player->getGameId(), $comparison);
        } elseif ($player instanceof ObjectCollection) {
            return $this
                ->usePlayerQuery()
                ->filterByPrimaryKeys($player->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function joinPlayer($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function usePlayerQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPlayer($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Player', '\PlayerQuery');
    }

    /**
     * Filter the query by a related \ResourceStore object
     *
     * @param \ResourceStore|ObjectCollection $resourceStore the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGameQuery The current query, for fluid interface
     */
    public function filterByResourceStore($resourceStore, $comparison = null)
    {
        if ($resourceStore instanceof \ResourceStore) {
            return $this
                ->addUsingAlias(GameTableMap::COL_ID, $resourceStore->getGameId(), $comparison);
        } elseif ($resourceStore instanceof ObjectCollection) {
            return $this
                ->useResourceStoreQuery()
                ->filterByPrimaryKeys($resourceStore->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByResourceStore() only accepts arguments of type \ResourceStore or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ResourceStore relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function joinResourceStore($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ResourceStore');

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
            $this->addJoinObject($join, 'ResourceStore');
        }

        return $this;
    }

    /**
     * Use the ResourceStore relation ResourceStore object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ResourceStoreQuery A secondary query class using the current class as primary query
     */
    public function useResourceStoreQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinResourceStore($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ResourceStore', '\ResourceStoreQuery');
    }

    /**
     * Filter the query by a related \TurnOrder object
     *
     * @param \TurnOrder|ObjectCollection $turnOrder the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGameQuery The current query, for fluid interface
     */
    public function filterByTurnOrder($turnOrder, $comparison = null)
    {
        if ($turnOrder instanceof \TurnOrder) {
            return $this
                ->addUsingAlias(GameTableMap::COL_ID, $turnOrder->getGameId(), $comparison);
        } elseif ($turnOrder instanceof ObjectCollection) {
            return $this
                ->useTurnOrderQuery()
                ->filterByPrimaryKeys($turnOrder->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTurnOrder() only accepts arguments of type \TurnOrder or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TurnOrder relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function joinTurnOrder($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TurnOrder');

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
            $this->addJoinObject($join, 'TurnOrder');
        }

        return $this;
    }

    /**
     * Use the TurnOrder relation TurnOrder object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \TurnOrderQuery A secondary query class using the current class as primary query
     */
    public function useTurnOrderQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTurnOrder($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TurnOrder', '\TurnOrderQuery');
    }

    /**
     * Filter the query by a related \GameCard object
     *
     * @param \GameCard|ObjectCollection $gameCard the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGameQuery The current query, for fluid interface
     */
    public function filterByGameCard($gameCard, $comparison = null)
    {
        if ($gameCard instanceof \GameCard) {
            return $this
                ->addUsingAlias(GameTableMap::COL_ID, $gameCard->getGameId(), $comparison);
        } elseif ($gameCard instanceof ObjectCollection) {
            return $this
                ->useGameCardQuery()
                ->filterByPrimaryKeys($gameCard->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGameCard() only accepts arguments of type \GameCard or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GameCard relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function joinGameCard($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GameCard');

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
            $this->addJoinObject($join, 'GameCard');
        }

        return $this;
    }

    /**
     * Use the GameCard relation GameCard object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GameCardQuery A secondary query class using the current class as primary query
     */
    public function useGameCardQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGameCard($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GameCard', '\GameCardQuery');
    }

    /**
     * Filter the query by a related \GameCity object
     *
     * @param \GameCity|ObjectCollection $gameCity the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGameQuery The current query, for fluid interface
     */
    public function filterByGameCity($gameCity, $comparison = null)
    {
        if ($gameCity instanceof \GameCity) {
            return $this
                ->addUsingAlias(GameTableMap::COL_ID, $gameCity->getGameId(), $comparison);
        } elseif ($gameCity instanceof ObjectCollection) {
            return $this
                ->useGameCityQuery()
                ->filterByPrimaryKeys($gameCity->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGameCity() only accepts arguments of type \GameCity or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GameCity relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function joinGameCity($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GameCity');

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
            $this->addJoinObject($join, 'GameCity');
        }

        return $this;
    }

    /**
     * Use the GameCity relation GameCity object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GameCityQuery A secondary query class using the current class as primary query
     */
    public function useGameCityQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGameCity($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GameCity', '\GameCityQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildGame $game Object to remove from the list of results
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function prune($game = null)
    {
        if ($game) {
            $this->addUsingAlias(GameTableMap::COL_ID, $game->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the game table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GameTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GameTableMap::clearInstancePool();
            GameTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(GameTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(GameTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            GameTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            GameTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // GameQuery
