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
    return MultiProvider(
      providers: [ChangeNotifierProvider(create: (_) => GamesProvider())],
      child: MaterialApp(
        debugShowCheckedModeBanner: false,
        title: 'TGP FTP',
        theme: ThemeData(colorScheme: .fromSeed(seedColor: primaryColor)),
        home: SplashScreen(),
      ),
    );
  }
}
