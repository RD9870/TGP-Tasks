import 'dart:convert';
import 'package:flutter/foundation.dart';
import 'package:http/http.dart' as http;
import 'package:tgp_games/helpers/consts.dart';
import 'package:tgp_games/models/game_model.dart';
import 'package:tgp_games/models/single_game_model.dart';
import 'package:url_launcher/url_launcher.dart';

class GamesProvider with ChangeNotifier {
  // loading indicator variable
  bool busy = false;
  // failed variable
  bool failed = false;

  // change the value of the loading indicator
  void setBusy(bool status) {
    busy = status;
    notifyListeners();
  }

  // change the value of the failed variable
  void setFailed(bool status) {
    failed = status;
    notifyListeners();
  }

  // list of games to display
  List<GameModel> games = [];

  // get the games from the backend
  void getGames(String? platformQuery) async {
    setBusy(true);
    final response = await http.get(
      Uri.parse(
        "$baseUrl/games${platformQuery != null ? "?platform=${platformQuery.toLowerCase()}" : ""}",
      ),
    );
    // print some info in the debug mode
    if (kDebugMode) {
      print(
        "RESPONSE GET : $baseUrl/games${platformQuery != null ? "?platform=${platformQuery.toLowerCase()}" : ""}",
      );
      print("RESPONSE STATUS CODE : ${response.statusCode}");
      print("RESPONSE BODY : ${response.body}");
    }
    // backend response is ok
    if (response.statusCode == 200) {
      var decodedData = jsonDecode(response.body);
      // todo TASK 1 REFACTOR DONE
      // add the fetched data to the displayed list
      games = List<GameModel>.from(
        decodedData.map((game) {
          return GameModel.fromJson(game);
        }),
      );
      setFailed(false);
      setBusy(false);
    }
    // backend response is not ok
    else {
      // set the failed variable to true
      setFailed(true);
      setBusy(false);
    }
  }

  // user selected one game to view it;s details
  SingleGameModel? currentGameModel;
  // get the details of one game
  Future<void> getSingleGame(String gId) async {
    // reset the variable
    currentGameModel = null;
    setBusy(true);
    // get the details of the game from the backend
    final response = await http.get(Uri.parse("$baseUrl/game?id=$gId"));
    // if in debug mode show some useful info
    if (kDebugMode) {
      print("RESPONSE GET for $gId : $baseUrl/game?id=$gId");
      print("RESPONSE STATUS CODE : ${response.statusCode}");
      print("RESPONSE BODY : ${response.body}");
    }
    // backend response if ok
    if (response.statusCode == 200) {
      // ubdate the current game variable
      currentGameModel = SingleGameModel.fromJson(jsonDecode(response.body));
      setBusy(false);
      setFailed(false);
    } else {
      setBusy(false);
      setFailed(true);
    }
  }

  // launch the freetogame_profile_url or game_url in the in app browser
  Future<void> launchInBrowserView(Uri url) async {
    // show error if something goes wrong
    if (!await launchUrl(url, mode: LaunchMode.inAppBrowserView)) {
      throw Exception('Could not launch $url');
    }
  }
}



// "id":540,
// "title":"Overwatch 2",
// "thumbnail":"https:\/\/www.freetogame.com\/g\/540\/thumbnail.jpg",
// "short_description":"A hero-focused first-person team shooter from Blizzard Entertainment.",
// "game_url":"https:\/\/www.freetogame.com\/open\/overwatch-2",
// "genre":"Shooter",
// "platform":"PC (Windows)",
// "publisher":"Activision Blizzard",
// "developer":"Blizzard Entertainment",
// "release_date":"2022-10-04",
// "freetogame_profile_url":"https:\/\/www.freetogame.com\/overwatch-2"},{"id":516,"title":"PUBG: BATTLEGROUNDS","thumbnail":"https:\/\/www.freetogame.com\/g\/516\/thumbnail.jpg","short_description":"Get into the action in one of the longest running battle royale games PUBG Battlegrounds.","game_url":"https:\/\/www.freetogame.com\/open\/pubg","genre":"Shooter","platform":"PC (Windows)","publisher":"KRAFTON, Inc.","developer":"KRAFTON, Inc.","release_date":"2022-01-12","freetogame_profile_url":"https:\/\/www.freetogame.com\/pubg"},{"id":508,"title":"Enlisted","thumbnail":"https:\/\/www.freetogame.com\/g\/508\