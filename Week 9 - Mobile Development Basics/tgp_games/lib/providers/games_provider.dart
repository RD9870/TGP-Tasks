import 'dart:convert';
import 'package:flutter/foundation.dart';
import 'package:http/http.dart' as http;
import 'package:tgp_games/helpers/consts.dart';
import 'package:tgp_games/models/game_model.dart';
import 'package:tgp_games/models/single_game_model.dart';
import 'package:url_launcher/url_launcher.dart';

class GamesProvider with ChangeNotifier {
  bool busy = false;

  void setBusy(bool status) {
    busy = status;
    notifyListeners();
  }

  bool failed = false;

  void setFailed(bool status) {
    failed = status;
    notifyListeners();
  }

  List<GameModel> games = [];

  void getGames(String? platformQuery) async {
    setBusy(true);
    final response = await http.get(
      Uri.parse(
        "$baseUrl/games${platformQuery != null ? "?platform=${platformQuery.toLowerCase()}" : ""}",
      ),
    );

    if (kDebugMode) {
      print(
        "RESPONSE GET : $baseUrl/games${platformQuery != null ? "?platform=${platformQuery.toLowerCase()}" : ""}",
      );
      print("RESPONSE STATUS CODE : ${response.statusCode}");
      print("RESPONSE BODY : ${response.body}");
    }
    if (response.statusCode == 200) {
      var decodedData = jsonDecode(response.body);
      // TODO TASK 1 REFACTOR DONE
      games = List<GameModel>.from(
        decodedData.map((game) {
          return GameModel.fromJson(game);
        }),
      );
      setFailed(false);
      setBusy(false);
    } else {
      setFailed(true);
      setBusy(false);
    }
  }

  SingleGameModel? currentGameModel;

  Future<void> getSingleGame(String gId) async {
    currentGameModel = null;
    setBusy(true);
    final response = await http.get(Uri.parse("$baseUrl/game?id=$gId"));

    if (kDebugMode) {
      print("RESPONSE GET for $gId : $baseUrl/game?id=$gId");
      print("RESPONSE STATUS CODE : ${response.statusCode}");
      print("RESPONSE BODY : ${response.body}");
    }

    if (response.statusCode == 200) {
      currentGameModel = SingleGameModel.fromJson(jsonDecode(response.body));
      setBusy(false);
      setFailed(false);
    } else {
      setBusy(false);
      setFailed(true);
    }
  }

  Future<void> launchInBrowserView(Uri url) async {
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