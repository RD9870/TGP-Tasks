import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:tgp_games/helpers/consts.dart';
import 'package:tgp_games/helpers/functions_helper.dart';
import 'package:tgp_games/providers/games_provider.dart';
import 'package:tgp_games/widgets/statics/shimmer_widget.dart';

class SingleGameScreen extends StatefulWidget {
  const SingleGameScreen({super.key, required this.gameId});
  final String gameId;
  @override
  State<SingleGameScreen> createState() => _SingleGameScreenState();
}

class _SingleGameScreenState extends State<SingleGameScreen> {
  @override
  void initState() {
    // get tyhe game details after the initial widget build
    WidgetsBinding.instance.addPostFrameCallback((_) {
      Provider.of<GamesProvider>(
        context,
        listen: false,
      ).getSingleGame(widget.gameId);
    });
    super.initState();
  }

  //expand the description section variable
  bool textExpanded = false;

  @override
  Widget build(BuildContext context) {
    return Consumer<GamesProvider>(
      builder: (context, gamesConsumer, _) {
        return Scaffold(
          body: SingleChildScrollView(
            child: Column(
              children: [
                // show skeleton while data is being fetched
                gamesConsumer.currentGameModel == null
                    ? SizedBox(
                        width: getSize(context).width,
                        height: getSize(context).height * 0.25,
                        child: ShimmerWidget(),
                      )
                    // thumbnail image
                    : Image.network(
                        width: getSize(context).width,
                        height: getSize(context).height * 0.25,
                        fit: BoxFit.cover,
                        gamesConsumer.currentGameModel!.thumbnail,
                      ),
                // title
                Padding(
                  padding: const EdgeInsets.symmetric(
                    horizontal: 12,
                    vertical: 8,
                  ),
                  child: Row(
                    children: [
                      Expanded(
                        child: Text(
                          gamesConsumer.currentGameModel == null
                              ? "Loading..."
                              : gamesConsumer.currentGameModel!.title,
                          style: labelLarge,
                        ),
                      ),
                    ],
                  ),
                ),
                // description
                Padding(
                  padding: const EdgeInsets.all(8.0),
                  child: Text(
                    gamesConsumer.currentGameModel == null
                        ? "Loading..."
                        : gamesConsumer.currentGameModel!.description,
                    style: bodyMedium,
                    maxLines: textExpanded ? 100 : 2,
                    overflow: TextOverflow.ellipsis,
                  ),
                ),
                // expand description btn
                IconButton(
                  onPressed: () {
                    setState(() {
                      textExpanded = !textExpanded;
                    });
                  },
                  icon: Icon(
                    textExpanded
                        ? CupertinoIcons.chevron_up
                        : CupertinoIcons.chevron_down,
                  ),
                ),
                // image galleary
                SizedBox(
                  height: getSize(context).height * 0.2,
                  child: (gamesConsumer.currentGameModel != null)
                      ? ListView.builder(
                          scrollDirection: Axis.horizontal,
                          itemCount: gamesConsumer
                              .currentGameModel!
                              .screenshots
                              .length,
                          itemBuilder: (context, index) {
                            return Padding(
                              padding: const EdgeInsets.symmetric(
                                horizontal: 4,
                                vertical: 8,
                              ),
                              child: ClipRRect(
                                borderRadius: BorderRadius.circular(6),
                                child: Image.network(
                                  gamesConsumer
                                      .currentGameModel!
                                      .screenshots[index]
                                      .image,
                                ),
                              ),
                            );
                          },
                        )
                      // if game has no images show error
                      : (gamesConsumer.currentGameModel != null &&
                            gamesConsumer.currentGameModel!.screenshots.isEmpty)
                      ? Text("No Images Avaliable")
                      // loading indicator
                      : Text("Images Loading"),
                ),
                // show minimal system requirements in pc games
                (gamesConsumer.currentGameModel != null &&
                        gamesConsumer
                                .currentGameModel!
                                .minimumSystemRequirements !=
                            null)
                    // each requirement has a set name (os, graphics, memeory ect)
                    ? Column(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          Text(
                            "OS: ${gamesConsumer.currentGameModel!.minimumSystemRequirements!.os}",
                          ),
                          Text(
                            "GRAPGICS: ${gamesConsumer.currentGameModel!.minimumSystemRequirements!.graphics}",
                          ),
                          Text(
                            "MEMORY: ${gamesConsumer.currentGameModel!.minimumSystemRequirements!.memory}",
                          ),
                          Text(
                            "PROCESSER: ${gamesConsumer.currentGameModel!.minimumSystemRequirements!.processor}",
                          ),
                          Text(
                            "STORAGE: ${gamesConsumer.currentGameModel!.minimumSystemRequirements!.storage}",
                          ),
                        ],
                      )
                    : SizedBox(),
                // row of btns to see more info about game
                (gamesConsumer.currentGameModel != null)
                    ? Row(
                        mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                        children: [
                          // todo TASK 2 GAME URL BUTTON HERE & OPEN LINK DONE
                          TextButton(
                            style: ButtonStyle(
                              backgroundColor: WidgetStateProperty.all(
                                primaryColor,
                              ),
                            ),
                            // launch the game url in he phone browser
                            onPressed: () {
                              gamesConsumer.launchInBrowserView(
                                Uri.parse(
                                  gamesConsumer.currentGameModel!.gameUrl,
                                ),
                              );
                              debugPrint(
                                gamesConsumer.currentGameModel!.gameUrl,
                              );
                            },
                            child: Text(
                              style: TextStyle(color: whiteColor),
                              "Game URL",
                            ),
                          ),
                          // todo TASK 3 FREE TO PROFILE GAME URL BUTTON HERE & OPEN LINK DONE
                          // open the Free to Game Profile in the browser
                          TextButton(
                            style: ButtonStyle(
                              backgroundColor: WidgetStateProperty.all(
                                purpleColor,
                              ),
                            ),
                            onPressed: () {
                              gamesConsumer.launchInBrowserView(
                                Uri.parse(
                                  gamesConsumer
                                      .currentGameModel!
                                      .freetogameProfileUrl,
                                ),
                              );
                            },
                            child: Text(
                              style: TextStyle(color: whiteColor),
                              "Free to Game Profile",
                            ),
                          ),
                        ],
                      )
                    : SizedBox(),
              ],
            ),
          ),
        );
      },
    );
  }
}
