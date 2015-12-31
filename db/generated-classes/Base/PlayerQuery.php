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
 * @method     ChildPlayerQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildPlayerQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildPlayerQuery orderByGameId($order = Criteria::ASC) Order by the game_id column
 * @method     ChildPlayerQuery orderByWalletId($order = Criteria::ASC) Order by the wallet_id column
 * @method     ChildPlayerQuery orderByColorName($order = Criteria::ASC) Order by the color_name column
 *
 * @method     ChildPlayerQuery groupById() Group by the id column
 * @method     ChildPlayerQuery groupByName() Group by the name column
 * @method     ChildPlayerQuery groupByUserId() Group by the user_id column
 * @method     ChildPlayerQuery groupByGameId() Group by the game_id column
 * @method     ChildPlayerQuery groupByWalletId() Group by the wallet_id column
 * @method     ChildPlayerQuery groupByColorName() Group by the color_name column
 *
 * @method     ChildPlayerQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPlayerQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPlayerQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPlayerQuery leftJoinPlayerUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the PlayerUser relation
 * @method     ChildPlayerQuery rightJoinPlayerUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PlayerUser relation
 * @method     ChildPlayerQuery innerJoinPlayerUser($relationAlias = null) Adds a INNER JOIN clause to the query using the PlayerUser relation
 *
 * @method     ChildPlayerQuery leftJoinCurrentGame($relationAlias = null) Adds a LEFT JOIN clause to the query using the CurrentGame relation
 * @method     ChildPlayerQuery rightJoinCurrentGame($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CurrentGame relation
 * @method     ChildPlayerQuery innerJoinCurrentGame($relationAlias = null) Adds a INNER JOIN clause to the query using the CurrentGame relation
 *
 * @method     ChildPlayerQuery leftJoinPlayerWallet($relationAlias = null) Adds a LEFT JOIN clause to the query using the PlayerWallet relation
 * @method     ChildPlayerQuery rightJoinPlayerWallet($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PlayerWallet relation
 * @method     ChildPlayerQuery innerJoinPlayerWallet($relationAlias = null) Adds a INNER JOIN clause to the query using the PlayerWallet relation
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
 * @method     ChildPlayerQuery leftJoinCurrentAuctionPlant($relationAlias = null) Adds a LEFT JOIN clause to the query using the CurrentAuctionPlant relation
 * @method     ChildPlayerQuery rightJoinCurrentAuctionPlant($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CurrentAuctionPlant relation
 * @method     ChildPlayerQuery innerJoinCurrentAuctionPlant($relationAlias = null) Adds a INNER JOIN clause to the query using the CurrentAuctionPlant relation
 *
 * @method     ChildPlayerQuery leftJoinPlayerAuctionAction($relationAlias = null) Adds a LEFT JOIN clause to the query using the PlayerAuctionAction relation
 * @method     ChildPlayerQuery rightJoinPlayerAuctionAction($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PlayerAuctionAction relation
 * @method     ChildPlayerQuery innerJoinPlayerAuctionAction($relationAlias = null) Adds a INNER JOIN clause to the query using the PlayerAuctionAction relation
 *
 * @method     \UserQuery|\GameQuery|\WalletQuery|\TurnOrderQuery|\PlayerResourceQuery|\PlayerCityQuery|\PlayerCardQuery|\CurrentAuctionPlantQuery|\PlayerAuctionActionQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPlayer findOne(ConnectionInterface $con = null) Return the first ChildPlayer matching the query
 * @method     ChildPlayer findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPlayer matching the query, or a new ChildPlayer object populated from the query conditions when no match is found
 *
 * @method     ChildPlayer findOneById(int $id) Return the first ChildPlayer filtered by the id column
 * @method     ChildPlayer findOneByName(string $name) Return the first ChildPlayer filtered by the name column
 * @method     ChildPlayer findOneByUserId(int $user_id) Return the first ChildPlayer filtered by the user_id column
 * @method     ChildPlayer findOneByGameId(int $game_id) Return the first ChildPlayer filtered by the game_id column
 * @method     ChildPlayer findOneByWalletId(int $wallet_id) Return the first ChildPlayer filtered by the wallet_id column
 * @method     ChildPlayer findOneByColorName(string $color_name) Return the first ChildPlayer filtered by the color_name column *

 * @method     ChildPlayer requirePk($key, ConnectionInterface $con = null) Return the ChildPlayer by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlayer requireOne(ConnectionInterface $con = null) Return the first ChildPlayer matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPlayer requireOneById(int $id) Return the first ChildPlayer filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlayer requireOneByName(string $name) Return the first ChildPlayer filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlayer requireOneByUserId(int $user_id) Return the first ChildPlayer filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlayer requireOneByGameId(int $game_id) Return the first ChildPlayer filtered by the game_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlayer requireOneByWalletId(int $wallet_id) Return the first ChildPlayer filtered by the wallet_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlayer requireOneByColorName(string $color_name) Return the first ChildPlayer filtered by the color_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPlayer[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPlayer objects based on current ModelCriteria
 * @method     ChildPlayer[]|ObjectCollection findById(int $id) Return ChildPlayer objects filtered by the id column
 * @method     ChildPlayer[]|ObjectCollection findByName(string $name) Return ChildPlayer objects filtered by the name column
 * @method     ChildPlayer[]|ObjectCollection findByUserId(int $user_id) Return ChildPlayer objects filtered by the user_id column
 * @method     ChildPlayer[]|ObjectCollection findByGameId(int $game_id) Return ChildPlayer objects filtered by the game_id column
 * @method     ChildPlayer[]|ObjectCollection findByWalletId(int $wallet_id) Return ChildPlayer objects filtered by the wallet_id column
 * @method     ChildPlayer[]|ObjectCollection findByColorName(string $color_name) Return ChildPlayer objects filtered by the color_name column
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
        $sql = 'SELECT id, name, user_id, game_id, wallet_id, color_name FROM player WHERE id = :p0';
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
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PlayerTableMap::COL_NAME, $name, $comparison);
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
     * @see       filterByPlayerUser()
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
     * @see       filterByCurrentGame()
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
     * @see       filterByPlayerWallet()
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
     * Filter the query on the color_name column
     *
     * Example usage:
     * <code>
     * $query->filterByColorName('fooValue');   // WHERE color_name = 'fooValue'
     * $query->filterByColorName('%fooValue%'); // WHERE color_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $colorName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function filterByColorName($colorName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($colorName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $colorName)) {
                $colorName = str_replace('*', '%', $colorName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PlayerTableMap::COL_COLOR_NAME, $colorName, $comparison);
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
    public function filterByPlayerUser($user, $comparison = null)
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
            throw new PropelException('filterByPlayerUser() only accepts arguments of type \User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PlayerUser relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function joinPlayerUser($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PlayerUser');

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
            $this->addJoinObject($join, 'PlayerUser');
        }

        return $this;
    }

    /**
     * Use the PlayerUser relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UserQuery A secondary query class using the current class as primary query
     */
    public function usePlayerUserQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPlayerUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PlayerUser', '\UserQuery');
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
    public function filterByCurrentGame($game, $comparison = null)
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
            throw new PropelException('filterByCurrentGame() only accepts arguments of type \Game or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CurrentGame relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function joinCurrentGame($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CurrentGame');

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
            $this->addJoinObject($join, 'CurrentGame');
        }

        return $this;
    }

    /**
     * Use the CurrentGame relation Game object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GameQuery A secondary query class using the current class as primary query
     */
    public function useCurrentGameQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCurrentGame($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CurrentGame', '\GameQuery');
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
    public function filterByPlayerWallet($wallet, $comparison = null)
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
            throw new PropelException('filterByPlayerWallet() only accepts arguments of type \Wallet or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PlayerWallet relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function joinPlayerWallet($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PlayerWallet');

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
            $this->addJoinObject($join, 'PlayerWallet');
        }

        return $this;
    }

    /**
     * Use the PlayerWallet relation Wallet object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \WalletQuery A secondary query class using the current class as primary query
     */
    public function usePlayerWalletQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPlayerWallet($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PlayerWallet', '\WalletQuery');
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
    public function joinTurnOrder($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useTurnOrderQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
     * Filter the query by a related \CurrentAuctionPlant object
     *
     * @param \CurrentAuctionPlant|ObjectCollection $currentAuctionPlant the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPlayerQuery The current query, for fluid interface
     */
    public function filterByCurrentAuctionPlant($currentAuctionPlant, $comparison = null)
    {
        if ($currentAuctionPlant instanceof \CurrentAuctionPlant) {
            return $this
                ->addUsingAlias(PlayerTableMap::COL_ID, $currentAuctionPlant->getHighestBidderId(), $comparison);
        } elseif ($currentAuctionPlant instanceof ObjectCollection) {
            return $this
                ->useCurrentAuctionPlantQuery()
                ->filterByPrimaryKeys($currentAuctionPlant->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCurrentAuctionPlant() only accepts arguments of type \CurrentAuctionPlant or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CurrentAuctionPlant relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function joinCurrentAuctionPlant($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CurrentAuctionPlant');

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
            $this->addJoinObject($join, 'CurrentAuctionPlant');
        }

        return $this;
    }

    /**
     * Use the CurrentAuctionPlant relation CurrentAuctionPlant object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CurrentAuctionPlantQuery A secondary query class using the current class as primary query
     */
    public function useCurrentAuctionPlantQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCurrentAuctionPlant($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CurrentAuctionPlant', '\CurrentAuctionPlantQuery');
    }

    /**
     * Filter the query by a related \PlayerAuctionAction object
     *
     * @param \PlayerAuctionAction|ObjectCollection $playerAuctionAction the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPlayerQuery The current query, for fluid interface
     */
    public function filterByPlayerAuctionAction($playerAuctionAction, $comparison = null)
    {
        if ($playerAuctionAction instanceof \PlayerAuctionAction) {
            return $this
                ->addUsingAlias(PlayerTableMap::COL_ID, $playerAuctionAction->getPlayerId(), $comparison);
        } elseif ($playerAuctionAction instanceof ObjectCollection) {
            return $this
                ->usePlayerAuctionActionQuery()
                ->filterByPrimaryKeys($playerAuctionAction->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPlayerAuctionAction() only accepts arguments of type \PlayerAuctionAction or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PlayerAuctionAction relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function joinPlayerAuctionAction($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PlayerAuctionAction');

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
            $this->addJoinObject($join, 'PlayerAuctionAction');
        }

        return $this;
    }

    /**
     * Use the PlayerAuctionAction relation PlayerAuctionAction object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PlayerAuctionActionQuery A secondary query class using the current class as primary query
     */
    public function usePlayerAuctionActionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPlayerAuctionAction($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PlayerAuctionAction', '\PlayerAuctionActionQuery');
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
