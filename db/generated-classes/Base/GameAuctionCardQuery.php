<?php

namespace Base;

use \GameAuctionCard as ChildGameAuctionCard;
use \GameAuctionCardQuery as ChildGameAuctionCardQuery;
use \Exception;
use \PDO;
use Map\GameAuctionCardTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'game_auction_card' table.
 *
 *
 *
 * @method     ChildGameAuctionCardQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildGameAuctionCardQuery orderByGameId($order = Criteria::ASC) Order by the game_id column
 * @method     ChildGameAuctionCardQuery orderByCardId($order = Criteria::ASC) Order by the card_id column
 *
 * @method     ChildGameAuctionCardQuery groupById() Group by the id column
 * @method     ChildGameAuctionCardQuery groupByGameId() Group by the game_id column
 * @method     ChildGameAuctionCardQuery groupByCardId() Group by the card_id column
 *
 * @method     ChildGameAuctionCardQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildGameAuctionCardQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildGameAuctionCardQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildGameAuctionCardQuery leftJoinGame($relationAlias = null) Adds a LEFT JOIN clause to the query using the Game relation
 * @method     ChildGameAuctionCardQuery rightJoinGame($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Game relation
 * @method     ChildGameAuctionCardQuery innerJoinGame($relationAlias = null) Adds a INNER JOIN clause to the query using the Game relation
 *
 * @method     ChildGameAuctionCardQuery leftJoinGameCard($relationAlias = null) Adds a LEFT JOIN clause to the query using the GameCard relation
 * @method     ChildGameAuctionCardQuery rightJoinGameCard($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GameCard relation
 * @method     ChildGameAuctionCardQuery innerJoinGameCard($relationAlias = null) Adds a INNER JOIN clause to the query using the GameCard relation
 *
 * @method     ChildGameAuctionCardQuery leftJoinCurrentAuctionPlant($relationAlias = null) Adds a LEFT JOIN clause to the query using the CurrentAuctionPlant relation
 * @method     ChildGameAuctionCardQuery rightJoinCurrentAuctionPlant($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CurrentAuctionPlant relation
 * @method     ChildGameAuctionCardQuery innerJoinCurrentAuctionPlant($relationAlias = null) Adds a INNER JOIN clause to the query using the CurrentAuctionPlant relation
 *
 * @method     \GameQuery|\GameCardQuery|\CurrentAuctionPlantQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildGameAuctionCard findOne(ConnectionInterface $con = null) Return the first ChildGameAuctionCard matching the query
 * @method     ChildGameAuctionCard findOneOrCreate(ConnectionInterface $con = null) Return the first ChildGameAuctionCard matching the query, or a new ChildGameAuctionCard object populated from the query conditions when no match is found
 *
 * @method     ChildGameAuctionCard findOneById(int $id) Return the first ChildGameAuctionCard filtered by the id column
 * @method     ChildGameAuctionCard findOneByGameId(int $game_id) Return the first ChildGameAuctionCard filtered by the game_id column
 * @method     ChildGameAuctionCard findOneByCardId(int $card_id) Return the first ChildGameAuctionCard filtered by the card_id column *

 * @method     ChildGameAuctionCard requirePk($key, ConnectionInterface $con = null) Return the ChildGameAuctionCard by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGameAuctionCard requireOne(ConnectionInterface $con = null) Return the first ChildGameAuctionCard matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGameAuctionCard requireOneById(int $id) Return the first ChildGameAuctionCard filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGameAuctionCard requireOneByGameId(int $game_id) Return the first ChildGameAuctionCard filtered by the game_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGameAuctionCard requireOneByCardId(int $card_id) Return the first ChildGameAuctionCard filtered by the card_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGameAuctionCard[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildGameAuctionCard objects based on current ModelCriteria
 * @method     ChildGameAuctionCard[]|ObjectCollection findById(int $id) Return ChildGameAuctionCard objects filtered by the id column
 * @method     ChildGameAuctionCard[]|ObjectCollection findByGameId(int $game_id) Return ChildGameAuctionCard objects filtered by the game_id column
 * @method     ChildGameAuctionCard[]|ObjectCollection findByCardId(int $card_id) Return ChildGameAuctionCard objects filtered by the card_id column
 * @method     ChildGameAuctionCard[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class GameAuctionCardQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\GameAuctionCardQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'powergrid', $modelName = '\\GameAuctionCard', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildGameAuctionCardQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildGameAuctionCardQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildGameAuctionCardQuery) {
            return $criteria;
        }
        $query = new ChildGameAuctionCardQuery();
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
     * @return ChildGameAuctionCard|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = GameAuctionCardTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GameAuctionCardTableMap::DATABASE_NAME);
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
     * @return ChildGameAuctionCard A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, game_id, card_id FROM game_auction_card WHERE id = :p0';
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
            /** @var ChildGameAuctionCard $obj */
            $obj = new ChildGameAuctionCard();
            $obj->hydrate($row);
            GameAuctionCardTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildGameAuctionCard|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildGameAuctionCardQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(GameAuctionCardTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildGameAuctionCardQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(GameAuctionCardTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildGameAuctionCardQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(GameAuctionCardTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(GameAuctionCardTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GameAuctionCardTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildGameAuctionCardQuery The current query, for fluid interface
     */
    public function filterByGameId($gameId = null, $comparison = null)
    {
        if (is_array($gameId)) {
            $useMinMax = false;
            if (isset($gameId['min'])) {
                $this->addUsingAlias(GameAuctionCardTableMap::COL_GAME_ID, $gameId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($gameId['max'])) {
                $this->addUsingAlias(GameAuctionCardTableMap::COL_GAME_ID, $gameId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GameAuctionCardTableMap::COL_GAME_ID, $gameId, $comparison);
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
     * @see       filterByGameCard()
     *
     * @param     mixed $cardId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGameAuctionCardQuery The current query, for fluid interface
     */
    public function filterByCardId($cardId = null, $comparison = null)
    {
        if (is_array($cardId)) {
            $useMinMax = false;
            if (isset($cardId['min'])) {
                $this->addUsingAlias(GameAuctionCardTableMap::COL_CARD_ID, $cardId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cardId['max'])) {
                $this->addUsingAlias(GameAuctionCardTableMap::COL_CARD_ID, $cardId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GameAuctionCardTableMap::COL_CARD_ID, $cardId, $comparison);
    }

    /**
     * Filter the query by a related \Game object
     *
     * @param \Game|ObjectCollection $game The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGameAuctionCardQuery The current query, for fluid interface
     */
    public function filterByGame($game, $comparison = null)
    {
        if ($game instanceof \Game) {
            return $this
                ->addUsingAlias(GameAuctionCardTableMap::COL_GAME_ID, $game->getId(), $comparison);
        } elseif ($game instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GameAuctionCardTableMap::COL_GAME_ID, $game->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildGameAuctionCardQuery The current query, for fluid interface
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
     * Filter the query by a related \GameCard object
     *
     * @param \GameCard|ObjectCollection $gameCard The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGameAuctionCardQuery The current query, for fluid interface
     */
    public function filterByGameCard($gameCard, $comparison = null)
    {
        if ($gameCard instanceof \GameCard) {
            return $this
                ->addUsingAlias(GameAuctionCardTableMap::COL_CARD_ID, $gameCard->getId(), $comparison);
        } elseif ($gameCard instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GameAuctionCardTableMap::COL_CARD_ID, $gameCard->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildGameAuctionCardQuery The current query, for fluid interface
     */
    public function joinGameCard($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useGameCardQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinGameCard($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GameCard', '\GameCardQuery');
    }

    /**
     * Filter the query by a related \CurrentAuctionPlant object
     *
     * @param \CurrentAuctionPlant|ObjectCollection $currentAuctionPlant the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGameAuctionCardQuery The current query, for fluid interface
     */
    public function filterByCurrentAuctionPlant($currentAuctionPlant, $comparison = null)
    {
        if ($currentAuctionPlant instanceof \CurrentAuctionPlant) {
            return $this
                ->addUsingAlias(GameAuctionCardTableMap::COL_ID, $currentAuctionPlant->getCardId(), $comparison);
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
     * @return $this|ChildGameAuctionCardQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildGameAuctionCard $gameAuctionCard Object to remove from the list of results
     *
     * @return $this|ChildGameAuctionCardQuery The current query, for fluid interface
     */
    public function prune($gameAuctionCard = null)
    {
        if ($gameAuctionCard) {
            $this->addUsingAlias(GameAuctionCardTableMap::COL_ID, $gameAuctionCard->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the game_auction_card table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GameAuctionCardTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GameAuctionCardTableMap::clearInstancePool();
            GameAuctionCardTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(GameAuctionCardTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(GameAuctionCardTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            GameAuctionCardTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            GameAuctionCardTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // GameAuctionCardQuery
