<?php

namespace Base;

use \CityConnection as ChildCityConnection;
use \CityConnectionQuery as ChildCityConnectionQuery;
use \Exception;
use \PDO;
use Map\CityConnectionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'city_connection' table.
 *
 *
 *
 * @method     ChildCityConnectionQuery orderByCityFrom($order = Criteria::ASC) Order by the city_from column
 * @method     ChildCityConnectionQuery orderByCityTo($order = Criteria::ASC) Order by the city_to column
 * @method     ChildCityConnectionQuery orderByMapId($order = Criteria::ASC) Order by the map_id column
 * @method     ChildCityConnectionQuery orderByCost($order = Criteria::ASC) Order by the cost column
 *
 * @method     ChildCityConnectionQuery groupByCityFrom() Group by the city_from column
 * @method     ChildCityConnectionQuery groupByCityTo() Group by the city_to column
 * @method     ChildCityConnectionQuery groupByMapId() Group by the map_id column
 * @method     ChildCityConnectionQuery groupByCost() Group by the cost column
 *
 * @method     ChildCityConnectionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCityConnectionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCityConnectionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCityConnectionQuery leftJoinFromCity($relationAlias = null) Adds a LEFT JOIN clause to the query using the FromCity relation
 * @method     ChildCityConnectionQuery rightJoinFromCity($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FromCity relation
 * @method     ChildCityConnectionQuery innerJoinFromCity($relationAlias = null) Adds a INNER JOIN clause to the query using the FromCity relation
 *
 * @method     ChildCityConnectionQuery leftJoinToCity($relationAlias = null) Adds a LEFT JOIN clause to the query using the ToCity relation
 * @method     ChildCityConnectionQuery rightJoinToCity($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ToCity relation
 * @method     ChildCityConnectionQuery innerJoinToCity($relationAlias = null) Adds a INNER JOIN clause to the query using the ToCity relation
 *
 * @method     ChildCityConnectionQuery leftJoinMap($relationAlias = null) Adds a LEFT JOIN clause to the query using the Map relation
 * @method     ChildCityConnectionQuery rightJoinMap($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Map relation
 * @method     ChildCityConnectionQuery innerJoinMap($relationAlias = null) Adds a INNER JOIN clause to the query using the Map relation
 *
 * @method     \CityQuery|\MapQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCityConnection findOne(ConnectionInterface $con = null) Return the first ChildCityConnection matching the query
 * @method     ChildCityConnection findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCityConnection matching the query, or a new ChildCityConnection object populated from the query conditions when no match is found
 *
 * @method     ChildCityConnection findOneByCityFrom(int $city_from) Return the first ChildCityConnection filtered by the city_from column
 * @method     ChildCityConnection findOneByCityTo(int $city_to) Return the first ChildCityConnection filtered by the city_to column
 * @method     ChildCityConnection findOneByMapId(int $map_id) Return the first ChildCityConnection filtered by the map_id column
 * @method     ChildCityConnection findOneByCost(int $cost) Return the first ChildCityConnection filtered by the cost column *

 * @method     ChildCityConnection requirePk($key, ConnectionInterface $con = null) Return the ChildCityConnection by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCityConnection requireOne(ConnectionInterface $con = null) Return the first ChildCityConnection matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCityConnection requireOneByCityFrom(int $city_from) Return the first ChildCityConnection filtered by the city_from column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCityConnection requireOneByCityTo(int $city_to) Return the first ChildCityConnection filtered by the city_to column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCityConnection requireOneByMapId(int $map_id) Return the first ChildCityConnection filtered by the map_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCityConnection requireOneByCost(int $cost) Return the first ChildCityConnection filtered by the cost column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCityConnection[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCityConnection objects based on current ModelCriteria
 * @method     ChildCityConnection[]|ObjectCollection findByCityFrom(int $city_from) Return ChildCityConnection objects filtered by the city_from column
 * @method     ChildCityConnection[]|ObjectCollection findByCityTo(int $city_to) Return ChildCityConnection objects filtered by the city_to column
 * @method     ChildCityConnection[]|ObjectCollection findByMapId(int $map_id) Return ChildCityConnection objects filtered by the map_id column
 * @method     ChildCityConnection[]|ObjectCollection findByCost(int $cost) Return ChildCityConnection objects filtered by the cost column
 * @method     ChildCityConnection[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CityConnectionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\CityConnectionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'powergrid', $modelName = '\\CityConnection', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCityConnectionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCityConnectionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCityConnectionQuery) {
            return $criteria;
        }
        $query = new ChildCityConnectionQuery();
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
     * @param array[$city_from, $city_to] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildCityConnection|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CityConnectionTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CityConnectionTableMap::DATABASE_NAME);
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
     * @return ChildCityConnection A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT city_from, city_to, map_id, cost FROM city_connection WHERE city_from = :p0 AND city_to = :p1';
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
            /** @var ChildCityConnection $obj */
            $obj = new ChildCityConnection();
            $obj->hydrate($row);
            CityConnectionTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildCityConnection|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCityConnectionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(CityConnectionTableMap::COL_CITY_FROM, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(CityConnectionTableMap::COL_CITY_TO, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCityConnectionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(CityConnectionTableMap::COL_CITY_FROM, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(CityConnectionTableMap::COL_CITY_TO, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the city_from column
     *
     * Example usage:
     * <code>
     * $query->filterByCityFrom(1234); // WHERE city_from = 1234
     * $query->filterByCityFrom(array(12, 34)); // WHERE city_from IN (12, 34)
     * $query->filterByCityFrom(array('min' => 12)); // WHERE city_from > 12
     * </code>
     *
     * @see       filterByFromCity()
     *
     * @param     mixed $cityFrom The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCityConnectionQuery The current query, for fluid interface
     */
    public function filterByCityFrom($cityFrom = null, $comparison = null)
    {
        if (is_array($cityFrom)) {
            $useMinMax = false;
            if (isset($cityFrom['min'])) {
                $this->addUsingAlias(CityConnectionTableMap::COL_CITY_FROM, $cityFrom['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cityFrom['max'])) {
                $this->addUsingAlias(CityConnectionTableMap::COL_CITY_FROM, $cityFrom['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CityConnectionTableMap::COL_CITY_FROM, $cityFrom, $comparison);
    }

    /**
     * Filter the query on the city_to column
     *
     * Example usage:
     * <code>
     * $query->filterByCityTo(1234); // WHERE city_to = 1234
     * $query->filterByCityTo(array(12, 34)); // WHERE city_to IN (12, 34)
     * $query->filterByCityTo(array('min' => 12)); // WHERE city_to > 12
     * </code>
     *
     * @see       filterByToCity()
     *
     * @param     mixed $cityTo The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCityConnectionQuery The current query, for fluid interface
     */
    public function filterByCityTo($cityTo = null, $comparison = null)
    {
        if (is_array($cityTo)) {
            $useMinMax = false;
            if (isset($cityTo['min'])) {
                $this->addUsingAlias(CityConnectionTableMap::COL_CITY_TO, $cityTo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cityTo['max'])) {
                $this->addUsingAlias(CityConnectionTableMap::COL_CITY_TO, $cityTo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CityConnectionTableMap::COL_CITY_TO, $cityTo, $comparison);
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
     * @return $this|ChildCityConnectionQuery The current query, for fluid interface
     */
    public function filterByMapId($mapId = null, $comparison = null)
    {
        if (is_array($mapId)) {
            $useMinMax = false;
            if (isset($mapId['min'])) {
                $this->addUsingAlias(CityConnectionTableMap::COL_MAP_ID, $mapId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($mapId['max'])) {
                $this->addUsingAlias(CityConnectionTableMap::COL_MAP_ID, $mapId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CityConnectionTableMap::COL_MAP_ID, $mapId, $comparison);
    }

    /**
     * Filter the query on the cost column
     *
     * Example usage:
     * <code>
     * $query->filterByCost(1234); // WHERE cost = 1234
     * $query->filterByCost(array(12, 34)); // WHERE cost IN (12, 34)
     * $query->filterByCost(array('min' => 12)); // WHERE cost > 12
     * </code>
     *
     * @param     mixed $cost The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCityConnectionQuery The current query, for fluid interface
     */
    public function filterByCost($cost = null, $comparison = null)
    {
        if (is_array($cost)) {
            $useMinMax = false;
            if (isset($cost['min'])) {
                $this->addUsingAlias(CityConnectionTableMap::COL_COST, $cost['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cost['max'])) {
                $this->addUsingAlias(CityConnectionTableMap::COL_COST, $cost['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CityConnectionTableMap::COL_COST, $cost, $comparison);
    }

    /**
     * Filter the query by a related \City object
     *
     * @param \City|ObjectCollection $city The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCityConnectionQuery The current query, for fluid interface
     */
    public function filterByFromCity($city, $comparison = null)
    {
        if ($city instanceof \City) {
            return $this
                ->addUsingAlias(CityConnectionTableMap::COL_CITY_FROM, $city->getId(), $comparison);
        } elseif ($city instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CityConnectionTableMap::COL_CITY_FROM, $city->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByFromCity() only accepts arguments of type \City or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FromCity relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCityConnectionQuery The current query, for fluid interface
     */
    public function joinFromCity($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FromCity');

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
            $this->addJoinObject($join, 'FromCity');
        }

        return $this;
    }

    /**
     * Use the FromCity relation City object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CityQuery A secondary query class using the current class as primary query
     */
    public function useFromCityQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFromCity($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FromCity', '\CityQuery');
    }

    /**
     * Filter the query by a related \City object
     *
     * @param \City|ObjectCollection $city The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCityConnectionQuery The current query, for fluid interface
     */
    public function filterByToCity($city, $comparison = null)
    {
        if ($city instanceof \City) {
            return $this
                ->addUsingAlias(CityConnectionTableMap::COL_CITY_TO, $city->getId(), $comparison);
        } elseif ($city instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CityConnectionTableMap::COL_CITY_TO, $city->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByToCity() only accepts arguments of type \City or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ToCity relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCityConnectionQuery The current query, for fluid interface
     */
    public function joinToCity($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ToCity');

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
            $this->addJoinObject($join, 'ToCity');
        }

        return $this;
    }

    /**
     * Use the ToCity relation City object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CityQuery A secondary query class using the current class as primary query
     */
    public function useToCityQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinToCity($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ToCity', '\CityQuery');
    }

    /**
     * Filter the query by a related \Map object
     *
     * @param \Map|ObjectCollection $map The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCityConnectionQuery The current query, for fluid interface
     */
    public function filterByMap($map, $comparison = null)
    {
        if ($map instanceof \Map) {
            return $this
                ->addUsingAlias(CityConnectionTableMap::COL_MAP_ID, $map->getId(), $comparison);
        } elseif ($map instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CityConnectionTableMap::COL_MAP_ID, $map->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildCityConnectionQuery The current query, for fluid interface
     */
    public function joinMap($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useMapQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMap($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Map', '\MapQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCityConnection $cityConnection Object to remove from the list of results
     *
     * @return $this|ChildCityConnectionQuery The current query, for fluid interface
     */
    public function prune($cityConnection = null)
    {
        if ($cityConnection) {
            $this->addCond('pruneCond0', $this->getAliasedColName(CityConnectionTableMap::COL_CITY_FROM), $cityConnection->getCityFrom(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(CityConnectionTableMap::COL_CITY_TO), $cityConnection->getCityTo(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the city_connection table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CityConnectionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CityConnectionTableMap::clearInstancePool();
            CityConnectionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CityConnectionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CityConnectionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CityConnectionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CityConnectionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CityConnectionQuery
