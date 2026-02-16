import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:tgp_games/helpers/consts.dart';
import 'package:tgp_games/helpers/functions_helper.dart';
import 'package:tgp_games/models/game_model.dart';
import 'package:tgp_games/screens/main_screens/single_game_screen.dart';

class GameCard extends StatelessWidget {
  const GameCard({super.key, required this.gameModel});
  final GameModel gameModel;
  @override
  Widget build(BuildContext context) {
    return
    // got to the songle game page to show game details
    GestureDetector(
      onTap: () {
        Navigator.push(
          context,
          CupertinoPageRoute(
            builder: (context) =>
                SingleGameScreen(gameId: gameModel.id.toString()),
          ),
        );
      },
      child:
          // game image
          ClipRRect(
            borderRadius: BorderRadiusGeometry.circular(12),
            // use GridTile to create a shadow effect on the thumbnail image
            child: GridTile(
              // top shadowy edges effect
              header: Container(
                decoration: BoxDecoration(
                  gradient: LinearGradient(
                    begin: Alignment.bottomCenter,
                    end: Alignment.topCenter,
                    colors: [Colors.transparent, Colors.black87],
                  ),
                ),
                child: Padding(
                  padding: const EdgeInsets.all(8.0),
                  child: Row(
                    children: [
                      // icon to show if it's a pc or browser game
                      Icon(
                        gameModel.platform.toLowerCase().contains(
                              "web".toLowerCase(),
                            )
                            ? Icons.web
                            : Icons.tv,
                        color: Colors.white,
                      ),
                    ],
                  ),
                ),
              ),
              // bottom shadowy edges effect
              footer: Container(
                height: getSize(context).height * 0.2,
                decoration: BoxDecoration(
                  gradient: LinearGradient(
                    begin: Alignment.bottomCenter,
                    end: Alignment.topCenter,
                    colors: [Colors.black87, Colors.transparent],
                  ),
                ),
                // game title
                child: Padding(
                  padding: const EdgeInsets.all(12.0),
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.end,
                    children: [
                      Row(
                        children: [
                          Expanded(
                            child: Text(
                              gameModel.title,
                              style: TextStyle(
                                color: whiteColor,
                                fontWeight: FontWeight.bold,
                              ),
                            ),
                          ),
                        ],
                      ),
                    ],
                  ),
                ),
              ),
              // game thumbnail image
              child: Image.network(gameModel.thumbnail, fit: BoxFit.cover),
            ),
          ),
    );
  }
}
