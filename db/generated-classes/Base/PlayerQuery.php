<?php

namespace Base;

use \Player as ChildPlayer;
use \PlayerQuery as ChildPlayerQuery;
use \Exception;
use \PDO;
use Map\PlayerTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'player' table.
 *
 *
 *
 * @method     ChildPlayerQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPlayerQuery orderByTurnNumber($order = Criteria::ASC) Order by the turn_number column
 * @method     ChildPlayerQuery orderByStepNumber($order = Criteria::ASC) Order by the step_number column
 * @method     ChildPlayerQuery orderByCardLimit($order = Criteria::ASC) Order by the card_limit column
 * @method     ChildPlayerQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildPlayerQuery orderByGameId($order = Criteria::ASC) Order by the game_id column
 * @method     ChildPlayerQuery orderByWalletId($order = Criteria::ASC) Order by the wallet_id column
 *
 * @method     ChildPlayerQuery groupById() Group by the id column
 * @method     ChildPlayerQuery groupByTurnNumber() Group by the turn_number column
 * @method     ChildPlayerQuery groupByStepNumber() Group by the step_number column
 * @method     ChildPlayerQuery groupByCardLimit() Group by the card_limit column
 * @method     ChildPlayerQuery groupByUserId() Group by the user_id column
 * @method     ChildPlayerQuery groupByGameId() Group by the game_id column
 * @method     ChildPlayerQuery groupByWalletId() Group by the wallet_id column
 *
 * @method     ChildPlayerQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPlayerQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPlayerQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPlayerQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildPlayerQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildPlayerQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildPlayerQuery leftJoinGame($relationAlias = null) Adds a LEFT JOIN clause to the query using the Game relation
 * @method     ChildPlayerQuery rightJoinGame($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Game relation
 * @method     ChildPlayerQuery innerJoinGame($relationAlias = null) Adds a INNER JOIN clause to the query using the Game relation
 *
 * @method     ChildPlayerQuery leftJoinWallet($relationAlias = null) Adds a LEFT JOIN clause to the query using the Wallet relation
 * @method     ChildPlayerQuery rightJoinWallet($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Wallet relation
 * @method     ChildPlayerQuery innerJoinWallet($relationAlias = null) Adds a INNER JOIN clause to the query using the Wallet relation
 *
 * @method     ChildPlayerQuery leftJoinTurnOrder($relationAlias = null) Adds a LEFT JOIN clause to the query using the TurnOrder relation
 * @method     ChildPlayerQuery rightJoinTurnOrder($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TurnOrder relation
 * @method     ChildPlayerQuery innerJoinTurnOrder($relationAlias = null) Adds a INNER JOIN clause to the query using the TurnOrder relation
 *
 * @method     ChildPlayerQuery leftJoinPlayerResource($relationAlias = null) Adds a LEFT JOIN clause to the query using the PlayerResource relation
 * @method     ChildPlayerQuery rightJoinPlayerResource($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PlayerResource relation
 * @method     ChildPlayerQuery innerJoinPlayerResource($relationAlias = null) Adds a INNER JOIN clause to the query using the PlayerResource relation
 *
 * @method     ChildPlayerQuery leftJoinPlayerCity($relationAlias = null) Adds a LEFT JOIN clause to the query using the PlayerCity relation
 * @method     ChildPlayerQuery rightJoinPlayerCity($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PlayerCity relation
 * @method     ChildPlayerQuery innerJoinPlayerCity($relationAlias = null) Adds a INNER JOIN clause to the query using the PlayerCity relation
 *
 * @method     ChildPlayerQuery leftJoinPlayerCard($relationAlias = null) Adds a LEFT JOIN clause to the query using the PlayerCard relation
 * @method     ChildPlayerQuery rightJoinPlayerCard($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PlayerCard relation
 * @method     ChildPlayerQuery innerJoinPlayerCard($relationAlias = null) Adds a INNER JOIN clause to the query using the PlayerCard relation
 *
 * @method     \UserQuery|\GameQuery|\WalletQuery|\TurnOrderQuery|\PlayerResourceQuery|\PlayerCityQuery|\PlayerCardQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPlayer findOne(ConnectionInterface $con = null) Return the first ChildPlayer matching the query
 * @method     ChildPlayer findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPlayer matching the query, or a new ChildPlayer object populated from the query conditions when no match is found
 *
 * @method     ChildPlayer findOneById(int $id) Return the first ChildPlayer filtered by the id column
 * @method     ChildPlayer findOneByTurnNumber(int $turn_number) Return the first ChildPlayer filtered by the turn_number column
 * @method     ChildPlayer findOneByStepNumber(int $step_number) Return the first ChildPlayer filtered by the step_number column
 * @method     ChildPlayer findOneByCardLimit(int $card_limit) Return the first ChildPlayer filtered by the card_limit column
 * @method     ChildPlayer findOneByUserId(int $user_id) Return the first ChildPlayer filtered by the user_id column
 * @method     ChildPlayer findOneByGameId(int $game_id) Return the first ChildPlayer filtered by the game_id column
 * @method     ChildPlayer findOneByWalletId(int $wallet_id) Return the first ChildPlayer filtered by the wallet_id column *

 * @method     ChildPlayer requirePk($key, ConnectionInterface $con = null) Return the ChildPlayer by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlayer requireOne(ConnectionInterface $con = null) Return the first ChildPlayer matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPlayer requireOneById(int $id) Return the first ChildPlayer filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlayer requireOneByTurnNumber(int $turn_number) Return the first ChildPlayer filtered by the turn_number column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlayer requireOneByStepNumber(int $step_number) Return the first ChildPlayer filtered by the step_number column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlayer requireOneByCardLimit(int $card_limit) Return the first ChildPlayer filtered by the card_limit column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlayer requireOneByUserId(int $user_id) Return the first ChildPlayer filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlayer requireOneByGameId(int $game_id) Return the first ChildPlayer filtered by the game_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlayer requireOneByWalletId(int $wallet_id) Return the first ChildPlayer filtered by the wallet_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPlayer[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPlayer objects based on current ModelCriteria
 * @method     ChildPlayer[]|ObjectCollection findById(int $id) Return ChildPlayer objects filtered by the id column
 * @method     ChildPlayer[]|ObjectCollection findByTurnNumber(int $turn_number) Return ChildPlayer objects filtered by the turn_number column
 * @method     ChildPlayer[]|ObjectCollection findByStepNumber(int $step_number) Return ChildPlayer objects filtered by the step_number column
 * @method     ChildPlayer[]|ObjectCollection findByCardLimit(int $card_limit) Return ChildPlayer objects filtered by the card_limit column
 * @method     ChildPlayer[]|ObjectCollection findByUserId(int $user_id) Return ChildPlayer objects filtered by the user_id column
 * @method     ChildPlayer[]|ObjectCollection findByGameId(int $game_id) Return ChildPlayer objects filtered by the game_id column
 * @method     ChildPlayer[]|ObjectCollection findByWalletId(int $wallet_id) Return ChildPlayer objects filtered by the wallet_id column
 * @method     ChildPlayer[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PlayerQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PlayerQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'powergrid', $modelName = '\\Player', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPlayerQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPlayerQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPlayerQuery) {
            return $criteria;
        }
        $query = new ChildPlayerQuery();
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
     * @return ChildPlayer|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PlayerTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PlayerTableMap::DATABASE_NAME);
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
     * @return ChildPlayer A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, turn_number, step_number, card_limit, user_id, game_id, wallet_id FROM player WHERE id = :p0';
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
            /** @var ChildPlayer $obj */
            $obj = new ChildPlayer();
            $obj->hydrate($row);
            PlayerTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPlayer|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PlayerTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PlayerTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PlayerTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PlayerTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlayerTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function filterByTurnNumber($turnNumber = null, $comparison = null)
    {
        if (is_array($turnNumber)) {
            $useMinMax = false;
            if (isset($turnNumber['min'])) {
                $this->addUsingAlias(PlayerTableMap::COL_TURN_NUMBER, $turnNumber['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($turnNumber['max'])) {
                $this->addUsingAlias(PlayerTableMap::COL_TURN_NUMBER, $turnNumber['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlayerTableMap::COL_TURN_NUMBER, $turnNumber, $comparison);
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
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function filterByStepNumber($stepNumber = null, $comparison = null)
    {
        if (is_array($stepNumber)) {
            $useMinMax = false;
            if (isset($stepNumber['min'])) {
                $this->addUsingAlias(PlayerTableMap::COL_STEP_NUMBER, $stepNumber['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($stepNumber['max'])) {
                $this->addUsingAlias(PlayerTableMap::COL_STEP_NUMBER, $stepNumber['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlayerTableMap::COL_STEP_NUMBER, $stepNumber, $comparison);
    }

    /**
     * Filter the query on the card_limit column
     *
     * Example usage:
     * <code>
     * $query->filterByCardLimit(1234); // WHERE card_limit = 1234
     * $query->filterByCardLimit(array(12, 34)); // WHERE card_limit IN (12, 34)
     * $query->filterByCardLimit(array('min' => 12)); // WHERE card_limit > 12
     * </code>
     *
     * @param     mixed $cardLimit The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function filterByCardLimit($cardLimit = null, $comparison = null)
    {
        if (is_array($cardLimit)) {
            $useMinMax = false;
            if (isset($cardLimit['min'])) {
                $this->addUsingAlias(PlayerTableMap::COL_CARD_LIMIT, $cardLimit['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cardLimit['max'])) {
                $this->addUsingAlias(PlayerTableMap::COL_CARD_LIMIT, $cardLimit['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlayerTableMap::COL_CARD_LIMIT, $cardLimit, $comparison);
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId(1234); // WHERE user_id = 1234
     * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
     * $query->filterByUserId(array('min' => 12)); // WHERE user_id > 12
     * </code>
     *
     * @see       filterByUser()
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(PlayerTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(PlayerTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlayerTableMap::COL_USER_ID, $userId, $comparison);
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
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function filterByGameId($gameId = null, $comparison = null)
    {
        if (is_array($gameId)) {
            $useMinMax = false;
            if (isset($gameId['min'])) {
                $this->addUsingAlias(PlayerTableMap::COL_GAME_ID, $gameId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($gameId['max'])) {
                $this->addUsingAlias(PlayerTableMap::COL_GAME_ID, $gameId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlayerTableMap::COL_GAME_ID, $gameId, $comparison);
    }

    /**
     * Filter the query on the wallet_id column
     *
     * Example usage:
     * <code>
     * $query->filterByWalletId(1234); // WHERE wallet_id = 1234
     * $query->filterByWalletId(array(12, 34)); // WHERE wallet_id IN (12, 34)
     * $query->filterByWalletId(array('min' => 12)); // WHERE wallet_id > 12
     * </code>
     *
     * @see       filterByWallet()
     *
     * @param     mixed $walletId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function filterByWalletId($walletId = null, $comparison = null)
    {
        if (is_array($walletId)) {
            $useMinMax = false;
            if (isset($walletId['min'])) {
                $this->addUsingAlias(PlayerTableMap::COL_WALLET_ID, $walletId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($walletId['max'])) {
                $this->addUsingAlias(PlayerTableMap::COL_WALLET_ID, $walletId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlayerTableMap::COL_WALLET_ID, $walletId, $comparison);
    }

    /**
     * Filter the query by a related \User object
     *
     * @param \User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPlayerQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \User) {
            return $this
                ->addUsingAlias(PlayerTableMap::COL_USER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PlayerTableMap::COL_USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildPlayerQuery The current query, for fluid interface
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
     * Filter the query by a related \Game object
     *
     * @param \Game|ObjectCollection $game The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPlayerQuery The current query, for fluid interface
     */
    public function filterByGame($game, $comparison = null)
    {
        if ($game instanceof \Game) {
            return $this
                ->addUsingAlias(PlayerTableMap::COL_GAME_ID, $game->getId(), $comparison);
        } elseif ($game instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PlayerTableMap::COL_GAME_ID, $game->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildPlayerQuery The current query, for fluid interface
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
     * Filter the query by a related \Wallet object
     *
     * @param \Wallet|ObjectCollection $wallet The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPlayerQuery The current query, for fluid interface
     */
    public function filterByWallet($wallet, $comparison = null)
    {
        if ($wallet instanceof \Wallet) {
            return $this
                ->addUsingAlias(PlayerTableMap::COL_WALLET_ID, $wallet->getId(), $comparison);
        } elseif ($wallet instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PlayerTableMap::COL_WALLET_ID, $wallet->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByWallet() only accepts arguments of type \Wallet or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Wallet relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function joinWallet($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Wallet');

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
            $this->addJoinObject($join, 'Wallet');
        }

        return $this;
    }

    /**
     * Use the Wallet relation Wallet object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \WalletQuery A secondary query class using the current class as primary query
     */
    public function useWalletQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinWallet($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Wallet', '\WalletQuery');
    }

    /**
     * Filter the query by a related \TurnOrder object
     *
     * @param \TurnOrder|ObjectCollection $turnOrder the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPlayerQuery The current query, for fluid interface
     */
    public function filterByTurnOrder($turnOrder, $comparison = null)
    {
        if ($turnOrder instanceof \TurnOrder) {
            return $this
                ->addUsingAlias(PlayerTableMap::COL_ID, $turnOrder->getPlayerId(), $comparison);
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
     * @return $this|ChildPlayerQuery The current query, for fluid interface
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
     * Filter the query by a related \PlayerResource object
     *
     * @param \PlayerResource|ObjectCollection $playerResource the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPlayerQuery The current query, for fluid interface
     */
    public function filterByPlayerResource($playerResource, $comparison = null)
    {
        if ($playerResource instanceof \PlayerResource) {
            return $this
                ->addUsingAlias(PlayerTableMap::COL_ID, $playerResource->getPlayerId(), $comparison);
        } elseif ($playerResource instanceof ObjectCollection) {
            return $this
                ->usePlayerResourceQuery()
                ->filterByPrimaryKeys($playerResource->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPlayerResource() only accepts arguments of type \PlayerResource or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PlayerResource relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function joinPlayerResource($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PlayerResource');

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
            $this->addJoinObject($join, 'PlayerResource');
        }

        return $this;
    }

    /**
     * Use the PlayerResource relation PlayerResource object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PlayerResourceQuery A secondary query class using the current class as primary query
     */
    public function usePlayerResourceQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPlayerResource($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PlayerResource', '\PlayerResourceQuery');
    }

    /**
     * Filter the query by a related \PlayerCity object
     *
     * @param \PlayerCity|ObjectCollection $playerCity the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPlayerQuery The current query, for fluid interface
     */
    public function filterByPlayerCity($playerCity, $comparison = null)
    {
        if ($playerCity instanceof \PlayerCity) {
            return $this
                ->addUsingAlias(PlayerTableMap::COL_ID, $playerCity->getPlayerId(), $comparison);
        } elseif ($playerCity instanceof ObjectCollection) {
            return $this
                ->usePlayerCityQuery()
                ->filterByPrimaryKeys($playerCity->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPlayerCity() only accepts arguments of type \PlayerCity or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PlayerCity relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function joinPlayerCity($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PlayerCity');

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
            $this->addJoinObject($join, 'PlayerCity');
        }

        return $this;
    }

    /**
     * Use the PlayerCity relation PlayerCity object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PlayerCityQuery A secondary query class using the current class as primary query
     */
    public function usePlayerCityQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPlayerCity($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PlayerCity', '\PlayerCityQuery');
    }

    /**
     * Filter the query by a related \PlayerCard object
     *
     * @param \PlayerCard|ObjectCollection $playerCard the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPlayerQuery The current query, for fluid interface
     */
    public function filterByPlayerCard($playerCard, $comparison = null)
    {
        if ($playerCard instanceof \PlayerCard) {
            return $this
                ->addUsingAlias(PlayerTableMap::COL_ID, $playerCard->getPlayerId(), $comparison);
        } elseif ($playerCard instanceof ObjectCollection) {
            return $this
                ->usePlayerCardQuery()
                ->filterByPrimaryKeys($playerCard->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPlayerCard() only accepts arguments of type \PlayerCard or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PlayerCard relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function joinPlayerCard($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PlayerCard');

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
            $this->addJoinObject($join, 'PlayerCard');
        }

        return $this;
    }

    /**
     * Use the PlayerCard relation PlayerCard object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PlayerCardQuery A secondary query class using the current class as primary query
     */
    public function usePlayerCardQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPlayerCard($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PlayerCard', '\PlayerCardQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPlayer $player Object to remove from the list of results
     *
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function prune($player = null)
    {
        if ($player) {
            $this->addUsingAlias(PlayerTableMap::COL_ID, $player->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the player table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PlayerTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PlayerTableMap::clearInstancePool();
            PlayerTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PlayerTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PlayerTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PlayerTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PlayerTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PlayerQuery
