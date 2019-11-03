Connection Details:

HTTPSConnection = "sportsop-soccer-sports-open-data-v1.p.rapidapi.com"
'x-rapidapi-host': "sportsop-soccer-sports-open-data-v1.p.rapidapi.com"
'x-rapidapi-key': "4777a60297msh383d23636d01510p16375ejsn40230e12fcd8"  


Use:
Limited to 100 requests a day or else additional fees are included
The python script has to be run with python 3 installed
The script genereates a csv with:
TeamName,Wins,Losses,Draws,Points*,Scores(goals),Conceded(goals),MatchesPlayed
Points*: win is 3 points, tie is 1, loss is 0: this is premier league rules

Idealy this script should automatically update the db.