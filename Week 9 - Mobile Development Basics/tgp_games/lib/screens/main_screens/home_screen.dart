import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:tgp_games/helpers/consts.dart';
import 'package:tgp_games/helpers/functions_helper.dart';
import 'package:tgp_games/providers/games_provider.dart';
import 'package:tgp_games/widgets/cards/game_card.dart';
import 'package:tgp_games/widgets/statics/shimmer_widget.dart';

class HomeScreen extends StatefulWidget {
  const HomeScreen({super.key});

  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  void fetchGames() {
    Provider.of<GamesProvider>(context, listen: false).getGames(
      cIndex == 0
          ? null
          : cIndex == 1
          ? "PC"
          : "browser",
    );
  }

  @override
  void initState() {
    WidgetsBinding.instance.addPostFrameCallback((_) {
      fetchGames();
    });
    super.initState();
  }

  int cIndex = 0;
  @override
  Widget build(BuildContext context) {
    return Consumer<GamesProvider>(
      builder: (context, gamesConsumer, _) {
        return Scaffold(
          floatingActionButton: FloatingActionButton(
            child: Text(gamesConsumer.games.length.toString()),
            onPressed: () {},
          ),
          body: Column(
            children: [
              Container(
                width: getSize(context).width,
                decoration: BoxDecoration(
                  gradient: LinearGradient(colors: [primaryColor, purpleColor]),
                ),
                child: Image.asset(
                  "assets/stupidLogo.png",
                  width: getSize(context).width * 0.2,
                  height: getSize(context).height * 0.1,
                  fit: BoxFit.contain,
                ),
              ),
              Expanded(
                child: RefreshIndicator(
                  onRefresh: () async {
                    WidgetsBinding.instance.addPostFrameCallback((_) {
                      fetchGames();
                    });
                  },
                  child: AnimatedSwitcher(
                    duration: animationDuration,
                    child: GridView.builder(
                      padding: EdgeInsets.all(8),
                      physics: AlwaysScrollableScrollPhysics(),

                      itemCount: gamesConsumer.busy
                          ? 6
                          : gamesConsumer.games.length,
                      gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
                        crossAxisCount: 2,
                        crossAxisSpacing: 8,
                        mainAxisSpacing: 8,
                        childAspectRatio: 0.7,
                      ),
                      itemBuilder: (context, index) {
                        return AnimatedSwitcher(
                          duration: animationDuration,
                          child: gamesConsumer.busy
                              ? ShimmerWidget()
                              : GameCard(gameModel: gamesConsumer.games[index]),
                        );
                      },
                    ),
                  ),
                ),
              ),
            ],
          ),

          bottomNavigationBar: BottomNavigationBar(
            currentIndex: cIndex,
            onTap: (value) {
              setState(() {
                cIndex = value;
              });
              WidgetsBinding.instance.addPostFrameCallback((_) {
                fetchGames();
              });
            },
            items: [
              BottomNavigationBarItem(label: "All", icon: Icon(Icons.gamepad)),
              BottomNavigationBarItem(label: "PC", icon: Icon(Icons.tv)),
              BottomNavigationBarItem(label: "Browser", icon: Icon(Icons.web)),
            ],
          ),
        );
      },
    );
  }
}
