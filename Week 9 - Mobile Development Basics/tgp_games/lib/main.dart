import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:tgp_games/helpers/consts.dart';
import 'package:tgp_games/providers/games_provider.dart';
import 'package:tgp_games/screens/auth_screen/splash_screen.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    // use MultiProvider widget to inject all the state providers used in the app
    return MultiProvider(
      providers: [ChangeNotifierProvider(create: (_) => GamesProvider())],
      child:
          // MaterialApp allows an app wide acess to theming, navigation, and access to Material Design widget
          MaterialApp(
            debugShowCheckedModeBanner: false,
            title: 'TGP FTP',
            theme: ThemeData(colorScheme: .fromSeed(seedColor: primaryColor)),
            home: SplashScreen(),
          ),
    );
  }
}
