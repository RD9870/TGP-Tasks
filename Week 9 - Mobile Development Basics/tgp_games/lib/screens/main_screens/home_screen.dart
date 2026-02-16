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
  // get the data from the api depending on the open tap (All, PC, Browser)
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
    // after the widget is created fetch the data
    WidgetsBinding.instance.addPostFrameCallback((_) {
      fetchGames();
    });
    super.initState();
  }

  // tab index
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
                    // fetch the games again
                    WidgetsBinding.instance.addPostFrameCallback((_) {
                      fetchGames();
                    });
                  },
                  // animated switcher allows for a smooth transition between it's children
                  child: AnimatedSwitcher(
                    duration: animationDuration,
                    child: GridView.builder(
                      padding: EdgeInsets.all(8),
                      physics: AlwaysScrollableScrollPhysics(),
                      itemCount: gamesConsumer.busy
                          ? 6 //for the skeletons
                          : gamesConsumer.games.length,
                      // display the games in a grid layout
                      gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
                        crossAxisCount: 2,
                        crossAxisSpacing: 8,
                        mainAxisSpacing: 8,
                        childAspectRatio: 0.7,
                      ),
                      itemBuilder: (context, index) {
                        // animate the switch between skeletons and actual data
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

          // nav bar
          bottomNavigationBar: BottomNavigationBar(
            currentIndex: cIndex,
            // chabge the insex when one of the taps is pressed
            onTap: (value) {
              setState(() {
                cIndex = value;
              });
              // fetch the games that go with the selected index
              WidgetsBinding.instance.addPostFrameCallback((_) {
                fetchGames();
              });
            },
            // navbar tabs
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
