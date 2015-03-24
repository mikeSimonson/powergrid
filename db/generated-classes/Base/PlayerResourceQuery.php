<?php

namespace Base;

use \PlayerResource as ChildPlayerResource;
use \PlayerResourceQuery as ChildPlayerResourceQuery;
use \Exception;
use \PDO;
use Map\PlayerResourceTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'player_resource' table.
 *
 *
 *
 * @method     ChildPlayerResourceQuery orderByPlayerId($order = Criteria::ASC) Order by the player_id column
 * @method     ChildPlayerResourceQuery orderByResourceTypeId($order = Criteria::ASC) Order by the resource_type_id column
 * @method     ChildPlayerResourceQuery orderByQuantity($order = Criteria::ASC) Order by the quantity column
 *
 * @method     ChildPlayerResourceQuery groupByPlayerId() Group by the player_id column
 * @method     ChildPlayerResourceQuery groupByResourceTypeId() Group by the resource_type_id column
 * @method     ChildPlayerResourceQuery groupByQuantity() Group by the quantity column
 *
 * @method     ChildPlayerResourceQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPlayerResourceQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPlayerResourceQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPlayerResourceQuery leftJoinResourceType($relationAlias = null) Adds a LEFT JOIN clause to the query using the ResourceType relation
 * @method     ChildPlayerResourceQuery rightJoinResourceType($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ResourceType relation
 * @method     ChildPlayerResourceQuery innerJoinResourceType($relationAlias = null) Adds a INNER JOIN clause to the query using the ResourceType relation
 *
 * @method     ChildPlayerResourceQuery leftJoinPlayer($relationAlias = null) Adds a LEFT JOIN clause to the query using the Player relation
 * @method     ChildPlayerResourceQuery rightJoinPlayer($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Player relation
 * @method     ChildPlayerResourceQuery innerJoinPlayer($relationAlias = null) Adds a INNER JOIN clause to the query using the Player relation
 *
 * @method     \ResourceTypeQuery|\PlayerQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPlayerResource findOne(ConnectionInterface $con = null) Return the first ChildPlayerResource matching the query
 * @method     ChildPlayerResource findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPlayerResource matching the query, or a new ChildPlayerResource object populated from the query conditions when no match is found
 *
 * @method     ChildPlayerResource findOneByPlayerId(int $player_id) Return the first ChildPlayerResource filtered by the player_id column
 * @method     ChildPlayerResource findOneByResourceTypeId(int $resource_type_id) Return the first ChildPlayerResource filtered by the resource_type_id column
 * @method     ChildPlayerResource findOneByQuantity(int $quantity) Return the first ChildPlayerResource filtered by the quantity column *

 * @method     ChildPlayerResource requirePk($key, ConnectionInterface $con = null) Return the ChildPlayerResource by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlayerResource requireOne(ConnectionInterface $con = null) Return the first ChildPlayerResource matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPlayerResource requireOneByPlayerId(int $player_id) Return the first ChildPlayerResource filtered by the player_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlayerResource requireOneByResourceTypeId(int $resource_type_id) Return the first ChildPlayerResource filtered by the resource_type_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlayerResource requireOneByQuantity(int $quantity) Return the first ChildPlayerResource filtered by the quantity column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPlayerResource[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPlayerResource objects based on current ModelCriteria
 * @method     ChildPlayerResource[]|ObjectCollection findByPlayerId(int $player_id) Return ChildPlayerResource objects filtered by the player_id column
 * @method     ChildPlayerResource[]|ObjectCollection findByResourceTypeId(int $resource_type_id) Return ChildPlayerResource objects filtered by the resource_type_id column
 * @method     ChildPlayerResource[]|ObjectCollection findByQuantity(int $quantity) Return ChildPlayerResource objects filtered by the quantity column
 * @method     ChildPlayerResource[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PlayerResourceQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PlayerResourceQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'powergrid', $modelName = '\\PlayerResource', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPlayerResourceQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPlayerResourceQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPlayerResourceQuery) {
            return $criteria;
        }
        $query = new ChildPlayerResourceQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$player_id, $resource_type_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildPlayerResource|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PlayerResourceTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PlayerResourceTableMap::DATABASE_NAME);
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
     * @return ChildPlayerResource A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT player_id, resource_type_id, quantity FROM player_resource WHERE player_id = :p0 AND resource_type_id = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildPlayerResource $obj */
            $obj = new ChildPlayerResource();
            $obj->hydrate($row);
            PlayerResourceTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildPlayerResource|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildPlayerResourceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(PlayerResourceTableMap::COL_PLAYER_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(PlayerResourceTableMap::COL_RESOURCE_TYPE_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPlayerResourceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(PlayerResourceTableMap::COL_PLAYER_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(PlayerResourceTableMap::COL_RESOURCE_TYPE_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @return $this|ChildPlayerResourceQuery The current query, for fluid interface
     */
    public function filterByPlayerId($playerId = null, $comparison = null)
    {
        if (is_array($playerId)) {
            $useMinMax = false;
            if (isset($playerId['min'])) {
                $this->addUsingAlias(PlayerResourceTableMap::COL_PLAYER_ID, $playerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($playerId['max'])) {
                $this->addUsingAlias(PlayerResourceTableMap::COL_PLAYER_ID, $playerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlayerResourceTableMap::COL_PLAYER_ID, $playerId, $comparison);
    }

    /**
     * Filter the query on the resource_type_id column
     *
     * Example usage:
     * <code>
     * $query->filterByResourceTypeId(1234); // WHERE resource_type_id = 1234
     * $query->filterByResourceTypeId(array(12, 34)); // WHERE resource_type_id IN (12, 34)
     * $query->filterByResourceTypeId(array('min' => 12)); // WHERE resource_type_id > 12
     * </code>
     *
     * @see       filterByResourceType()
     *
     * @param     mixed $resourceTypeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPlayerResourceQuery The current query, for fluid interface
     */
    public function filterByResourceTypeId($resourceTypeId = null, $comparison = null)
    {
        if (is_array($resourceTypeId)) {
            $useMinMax = false;
            if (isset($resourceTypeId['min'])) {
                $this->addUsingAlias(PlayerResourceTableMap::COL_RESOURCE_TYPE_ID, $resourceTypeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($resourceTypeId['max'])) {
                $this->addUsingAlias(PlayerResourceTableMap::COL_RESOURCE_TYPE_ID, $resourceTypeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlayerResourceTableMap::COL_RESOURCE_TYPE_ID, $resourceTypeId, $comparison);
    }

    /**
     * Filter the query on the quantity column
     *
     * Example usage:
     * <code>
     * $query->filterByQuantity(1234); // WHERE quantity = 1234
     * $query->filterByQuantity(array(12, 34)); // WHERE quantity IN (12, 34)
     * $query->filterByQuantity(array('min' => 12)); // WHERE quantity > 12
     * </code>
     *
     * @param     mixed $quantity The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPlayerResourceQuery The current query, for fluid interface
     */
    public function filterByQuantity($quantity = null, $comparison = null)
    {
        if (is_array($quantity)) {
            $useMinMax = false;
            if (isset($quantity['min'])) {
                $this->addUsingAlias(PlayerResourceTableMap::COL_QUANTITY, $quantity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantity['max'])) {
                $this->addUsingAlias(PlayerResourceTableMap::COL_QUANTITY, $quantity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlayerResourceTableMap::COL_QUANTITY, $quantity, $comparison);
    }

    /**
     * Filter the query by a related \ResourceType object
     *
     * @param \ResourceType|ObjectCollection $resourceType The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPlayerResourceQuery The current query, for fluid interface
     */
    public function filterByResourceType($resourceType, $comparison = null)
    {
        if ($resourceType instanceof \ResourceType) {
            return $this
                ->addUsingAlias(PlayerResourceTableMap::COL_RESOURCE_TYPE_ID, $resourceType->getId(), $comparison);
        } elseif ($resourceType instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PlayerResourceTableMap::COL_RESOURCE_TYPE_ID, $resourceType->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByResourceType() only accepts arguments of type \ResourceType or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ResourceType relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPlayerResourceQuery The current query, for fluid interface
     */
    public function joinResourceType($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ResourceType');

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
            $this->addJoinObject($join, 'ResourceType');
        }

        return $this;
    }

    /**
     * Use the ResourceType relation ResourceType object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ResourceTypeQuery A secondary query class using the current class as primary query
     */
    public function useResourceTypeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinResourceType($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ResourceType', '\ResourceTypeQuery');
    }

    /**
     * Filter the query by a related \Player object
     *
     * @param \Player|ObjectCollection $player The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPlayerResourceQuery The current query, for fluid interface
     */
    public function filterByPlayer($player, $comparison = null)
    {
        if ($player instanceof \Player) {
            return $this
                ->addUsingAlias(PlayerResourceTableMap::COL_PLAYER_ID, $player->getId(), $comparison);
        } elseif ($player instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PlayerResourceTableMap::COL_PLAYER_ID, $player->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildPlayerResourceQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildPlayerResource $playerResource Object to remove from the list of results
     *
     * @return $this|ChildPlayerResourceQuery The current query, for fluid interface
     */
    public function prune($playerResource = null)
    {
        if ($playerResource) {
            $this->addCond('pruneCond0', $this->getAliasedColName(PlayerResourceTableMap::COL_PLAYER_ID), $playerResource->getPlayerId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(PlayerResourceTableMap::COL_RESOURCE_TYPE_ID), $playerResource->getResourceTypeId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the player_resource table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PlayerResourceTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PlayerResourceTableMap::clearInstancePool();
            PlayerResourceTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PlayerResourceTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PlayerResourceTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PlayerResourceTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PlayerResourceTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PlayerResourceQuery
