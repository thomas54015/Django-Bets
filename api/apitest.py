import http.client
import mysql.connector

conn = http.client.HTTPSConnection("sportsop-soccer-sports-open-data-v1.p.rapidapi.com")

headers = {
    'x-rapidapi-host': "sportsop-soccer-sports-open-data-v1.p.rapidapi.com",
    'x-rapidapi-key': "4777a60297msh383d23636d01510p16375ejsn40230e12fcd8"  # requests are limited to 100/day
                                                                            # or else my credit card gets charged lol
    }

conn.request("GET", "/v1/leagues/premier-league/seasons/19-20/standings", headers=headers)

res = conn.getresponse()
data = res.read()

data = data.decode("utf-8")


f = open("data1.csv", "w+")
f.write(("Team,Wins,Losses,Draws,Points,Scores,Conceded,MatchesPlayed\n"))

dx = data.split("\"team\":")
for x in dx:
    if x == dx[0]:
        continue #header
    name = x.split(",")[0]
    wins = x.split("\"")[6].strip(":,")
    loss = x.split("\"")[10].strip(":,")
    tie = x.split("\"")[8].strip(":,")
    points = x.split("\"")[12].strip(":,")
    scores = x.split("\"")[14].strip(":,")
    conceded = x.split("\"")[16].strip(":,")
    matchesplayed = x.split("\"")[22].strip(":,")
    f.write(name+","+wins+","+loss+","+tie+","+points+","+scores+","+conceded+","+matchesplayed+"\n")
f.close()

mydb = mysql.connector.connect(
    host='localhost',
    user='djangoadmin',
    passwd='bestgroup',
    database='django'
)

if mydb.is_connected():
    f = open('data1.csv')
    for x in f:
        team, wins, losses, draws, points, scores, conceded, played = x.split(',')
        if team == "Team":
            continue
        cursor = mydb.cursor()
        query = ("UPDATE teams "
                 "SET wins="+wins+", losses="+losses+", draws="+draws+", points="+points+", scores="+scores +
                 ", conceded="+conceded+", played="+played +
                 "WHERE team="+team)
        cursor.execute(query)
    mydb.commit()

else:
    print("Could not connect to database, please check host,user,passwd")
