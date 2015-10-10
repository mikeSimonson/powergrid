import json
import sys

cities_file_obj = open(sys.argv[1], 'r')
connection_file_obj = open(sys.argv[2], 'r')
outfile_obj = open('cityconnections.json', 'w')

cities = json.load(cities_file_obj)
connections = json.load(connection_file_obj)


for connectionDict in connections:
    fromCityId = connectionDict['cities'][0]
    toCityId = connectionDict['cities'][1]
    connectionDict['cities'][0] = cities[fromCityId]
    connectionDict['cities'][1] = cities[toCityId]

json.dump(connections, outfile_obj, indent=2)
