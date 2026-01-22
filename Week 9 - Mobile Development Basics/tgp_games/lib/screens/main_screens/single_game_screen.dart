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
    WidgetsBinding.instance.addPostFrameCallback((_) {
      Provider.of<GamesProvider>(
        context,
        listen: false,
      ).getSingleGame(widget.gameId);
    });
    super.initState();
  }

  bool textExpanded = false;

  @override
  Widget build(BuildContext context) {
    return Consumer<GamesProvider>(
      builder: (context, gamesConsumer, _) {
        return Scaffold(
          body: SingleChildScrollView(
            child: Column(
              children: [
                gamesConsumer.currentGameModel == null
                    ? SizedBox(
                        width: getSize(context).width,
                        height: getSize(context).height * 0.25,

                        child: ShimmerWidget(),
                      )
                    : Image.network(
                        width: getSize(context).width,
                        height: getSize(context).height * 0.25,
                        fit: BoxFit.cover,
                        gamesConsumer.currentGameModel!.thumbnail,
                      ),

                Padding(
                  padding: const EdgeInsets.all(8.0),
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
                      : (gamesConsumer.currentGameModel != null &&
                            gamesConsumer.currentGameModel!.screenshots.isEmpty)
                      ? Text("No Images Avaliable")
                      : Text("Images Loading"),
                ),
                (gamesConsumer.currentGameModel != null &&
                        gamesConsumer
                                .currentGameModel!
                                .minimumSystemRequirements !=
                            null)
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
                (gamesConsumer.currentGameModel != null)
                    ? Row(
                        mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                        children: [
                          // TODO TASK 2 GAME URL BUTTON HERE & OPEN LINK DONE
                          // (gamesConsumer.currentGameModel!.gameUrl != null)
                          //     ?
                          TextButton(
                            style: ButtonStyle(
                              backgroundColor: WidgetStateProperty.all(
                                primaryColor,
                              ),
                            ),
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
                          // : SizedBox(),

                          // TODO TASK 3 FREE TO PROFILE GAME URL BUTTON HERE & OPEN LINK DONE
                          // (gamesConsumer.currentGameModel!.freetogameProfileUrl != null)
                          //     ?
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
                          // : SizedBox(),
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
