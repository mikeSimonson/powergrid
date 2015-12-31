<?php

namespace Base;

use \GameCard as ChildGameCard;
use \GameCardQuery as ChildGameCardQuery;
use \Exception;
use \PDO;
use Map\GameCardTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'game_card' table.
 *
 *
 *
 * @method     ChildGameCardQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildGameCardQuery orderByCardId($order = Criteria::ASC) Order by the card_id column
 * @method     ChildGameCardQuery orderByGameId($order = Criteria::ASC) Order by the game_id column
 *
 * @method     ChildGameCardQuery groupById() Group by the id column
 * @method     ChildGameCardQuery groupByCardId() Group by the card_id column
 * @method     ChildGameCardQuery groupByGameId() Group by the game_id column
 *
 * @method     ChildGameCardQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildGameCardQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildGameCardQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildGameCardQuery leftJoinGame($relationAlias = null) Adds a LEFT JOIN clause to the query using the Game relation
 * @method     ChildGameCardQuery rightJoinGame($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Game relation
 * @method     ChildGameCardQuery innerJoinGame($relationAlias = null) Adds a INNER JOIN clause to the query using the Game relation
 *
 * @method     ChildGameCardQuery leftJoinCard($relationAlias = null) Adds a LEFT JOIN clause to the query using the Card relation
 * @method     ChildGameCardQuery rightJoinCard($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Card relation
 * @method     ChildGameCardQuery innerJoinCard($relationAlias = null) Adds a INNER JOIN clause to the query using the Card relation
 *
 * @method     ChildGameCardQuery leftJoinDeckCard($relationAlias = null) Adds a LEFT JOIN clause to the query using the DeckCard relation
 * @method     ChildGameCardQuery rightJoinDeckCard($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DeckCard relation
 * @method     ChildGameCardQuery innerJoinDeckCard($relationAlias = null) Adds a INNER JOIN clause to the query using the DeckCard relation
 *
 * @method     ChildGameCardQuery leftJoinAuctionCard($relationAlias = null) Adds a LEFT JOIN clause to the query using the AuctionCard relation
 * @method     ChildGameCardQuery rightJoinAuctionCard($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AuctionCard relation
 * @method     ChildGameCardQuery innerJoinAuctionCard($relationAlias = null) Adds a INNER JOIN clause to the query using the AuctionCard relation
 *
 * @method     ChildGameCardQuery leftJoinPlayerCard($relationAlias = null) Adds a LEFT JOIN clause to the query using the PlayerCard relation
 * @method     ChildGameCardQuery rightJoinPlayerCard($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PlayerCard relation
 * @method     ChildGameCardQuery innerJoinPlayerCard($relationAlias = null) Adds a INNER JOIN clause to the query using the PlayerCard relation
 *
 * @method     \GameQuery|\CardQuery|\GameDeckCardQuery|\GameAuctionCardQuery|\PlayerCardQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildGameCard findOne(ConnectionInterface $con = null) Return the first ChildGameCard matching the query
 * @method     ChildGameCard findOneOrCreate(ConnectionInterface $con = null) Return the first ChildGameCard matching the query, or a new ChildGameCard object populated from the query conditions when no match is found
 *
 * @method     ChildGameCard findOneById(int $id) Return the first ChildGameCard filtered by the id column
 * @method     ChildGameCard findOneByCardId(int $card_id) Return the first ChildGameCard filtered by the card_id column
 * @method     ChildGameCard findOneByGameId(int $game_id) Return the first ChildGameCard filtered by the game_id column *

 * @method     ChildGameCard requirePk($key, ConnectionInterface $con = null) Return the ChildGameCard by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGameCard requireOne(ConnectionInterface $con = null) Return the first ChildGameCard matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGameCard requireOneById(int $id) Return the first ChildGameCard filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGameCard requireOneByCardId(int $card_id) Return the first ChildGameCard filtered by the card_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGameCard requireOneByGameId(int $game_id) Return the first ChildGameCard filtered by the game_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGameCard[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildGameCard objects based on current ModelCriteria
 * @method     ChildGameCard[]|ObjectCollection findById(int $id) Return ChildGameCard objects filtered by the id column
 * @method     ChildGameCard[]|ObjectCollection findByCardId(int $card_id) Return ChildGameCard objects filtered by the card_id column
 * @method     ChildGameCard[]|ObjectCollection findByGameId(int $game_id) Return ChildGameCard objects filtered by the game_id column
 * @method     ChildGameCard[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class GameCardQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\GameCardQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'powergrid', $modelName = '\\GameCard', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildGameCardQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildGameCardQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildGameCardQuery) {
            return $criteria;
        }
        $query = new ChildGameCardQuery();
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
     * @return ChildGameCard|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = GameCardTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GameCardTableMap::DATABASE_NAME);
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
     * @return ChildGameCard A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, card_id, game_id FROM game_card WHERE id = :p0';
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
            /** @var ChildGameCard $obj */
            $obj = new ChildGameCard();
            $obj->hydrate($row);
            GameCardTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildGameCard|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildGameCardQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(GameCardTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildGameCardQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(GameCardTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildGameCardQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(GameCardTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(GameCardTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GameCardTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildGameCardQuery The current query, for fluid interface
     */
    public function filterByCardId($cardId = null, $comparison = null)
    {
        if (is_array($cardId)) {
            $useMinMax = false;
            if (isset($cardId['min'])) {
                $this->addUsingAlias(GameCardTableMap::COL_CARD_ID, $cardId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cardId['max'])) {
                $this->addUsingAlias(GameCardTableMap::COL_CARD_ID, $cardId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GameCardTableMap::COL_CARD_ID, $cardId, $comparison);
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
     * @return $this|ChildGameCardQuery The current query, for fluid interface
     */
    public function filterByGameId($gameId = null, $comparison = null)
    {
        if (is_array($gameId)) {
            $useMinMax = false;
            if (isset($gameId['min'])) {
                $this->addUsingAlias(GameCardTableMap::COL_GAME_ID, $gameId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($gameId['max'])) {
                $this->addUsingAlias(GameCardTableMap::COL_GAME_ID, $gameId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GameCardTableMap::COL_GAME_ID, $gameId, $comparison);
    }

    /**
     * Filter the query by a related \Game object
     *
     * @param \Game|ObjectCollection $game The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGameCardQuery The current query, for fluid interface
     */
    public function filterByGame($game, $comparison = null)
    {
        if ($game instanceof \Game) {
            return $this
                ->addUsingAlias(GameCardTableMap::COL_GAME_ID, $game->getId(), $comparison);
        } elseif ($game instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GameCardTableMap::COL_GAME_ID, $game->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildGameCardQuery The current query, for fluid interface
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
     * Filter the query by a related \Card object
     *
     * @param \Card|ObjectCollection $card The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGameCardQuery The current query, for fluid interface
     */
    public function filterByCard($card, $comparison = null)
    {
        if ($card instanceof \Card) {
            return $this
                ->addUsingAlias(GameCardTableMap::COL_CARD_ID, $card->getId(), $comparison);
        } elseif ($card instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GameCardTableMap::COL_CARD_ID, $card->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCard() only accepts arguments of type \Card or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Card relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGameCardQuery The current query, for fluid interface
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
     * Use the Card relation Card object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CardQuery A secondary query class using the current class as primary query
     */
    public function useCardQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCard($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Card', '\CardQuery');
    }

    /**
     * Filter the query by a related \GameDeckCard object
     *
     * @param \GameDeckCard|ObjectCollection $gameDeckCard the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGameCardQuery The current query, for fluid interface
     */
    public function filterByDeckCard($gameDeckCard, $comparison = null)
    {
        if ($gameDeckCard instanceof \GameDeckCard) {
            return $this
                ->addUsingAlias(GameCardTableMap::COL_ID, $gameDeckCard->getCardId(), $comparison);
        } elseif ($gameDeckCard instanceof ObjectCollection) {
            return $this
                ->useDeckCardQuery()
                ->filterByPrimaryKeys($gameDeckCard->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDeckCard() only accepts arguments of type \GameDeckCard or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DeckCard relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGameCardQuery The current query, for fluid interface
     */
    public function joinDeckCard($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DeckCard');

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
            $this->addJoinObject($join, 'DeckCard');
        }

        return $this;
    }

    /**
     * Use the DeckCard relation GameDeckCard object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GameDeckCardQuery A secondary query class using the current class as primary query
     */
    public function useDeckCardQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDeckCard($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DeckCard', '\GameDeckCardQuery');
    }

    /**
     * Filter the query by a related \GameAuctionCard object
     *
     * @param \GameAuctionCard|ObjectCollection $gameAuctionCard the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGameCardQuery The current query, for fluid interface
     */
    public function filterByAuctionCard($gameAuctionCard, $comparison = null)
    {
        if ($gameAuctionCard instanceof \GameAuctionCard) {
            return $this
                ->addUsingAlias(GameCardTableMap::COL_ID, $gameAuctionCard->getCardId(), $comparison);
        } elseif ($gameAuctionCard instanceof ObjectCollection) {
            return $this
                ->useAuctionCardQuery()
                ->filterByPrimaryKeys($gameAuctionCard->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAuctionCard() only accepts arguments of type \GameAuctionCard or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AuctionCard relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGameCardQuery The current query, for fluid interface
     */
    public function joinAuctionCard($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AuctionCard');

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
            $this->addJoinObject($join, 'AuctionCard');
        }

        return $this;
    }

    /**
     * Use the AuctionCard relation GameAuctionCard object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GameAuctionCardQuery A secondary query class using the current class as primary query
     */
    public function useAuctionCardQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAuctionCard($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AuctionCard', '\GameAuctionCardQuery');
    }

    /**
     * Filter the query by a related \PlayerCard object
     *
     * @param \PlayerCard|ObjectCollection $playerCard the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGameCardQuery The current query, for fluid interface
     */
    public function filterByPlayerCard($playerCard, $comparison = null)
    {
        if ($playerCard instanceof \PlayerCard) {
            return $this
                ->addUsingAlias(GameCardTableMap::COL_ID, $playerCard->getCardId(), $comparison);
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
     * @return $this|ChildGameCardQuery The current query, for fluid interface
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
     * @param   ChildGameCard $gameCard Object to remove from the list of results
     *
     * @return $this|ChildGameCardQuery The current query, for fluid interface
     */
    public function prune($gameCard = null)
    {
        if ($gameCard) {
            $this->addUsingAlias(GameCardTableMap::COL_ID, $gameCard->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the game_card table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GameCardTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GameCardTableMap::clearInstancePool();
            GameCardTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(GameCardTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(GameCardTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            GameCardTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            GameCardTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // GameCardQuery
