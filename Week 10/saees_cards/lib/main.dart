import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:saees_cards/providers/auth_provider.dart';
import 'package:saees_cards/providers/qr_provider.dart';
import 'package:saees_cards/providers/upload_image_provider.dart';
import 'package:saees_cards/screens/auth_screens/intro_screen.dart';
import 'package:saees_cards/screens/handling_screens/loading_screen.dart';
import 'package:saees_cards/screens/handling_screens/wrong.dart';
import 'package:saees_cards/screens/main_screens/tabs_screen.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    return MultiProvider(
      providers: [
        ChangeNotifierProvider(create: (_) => QrProvider()),
        ChangeNotifierProvider(create: (_) => UploadImageProvider()),
        ChangeNotifierProvider(create: (_) => AuthProvider()),
      ],
      child: MaterialApp(
        debugShowCheckedModeBanner: false,
        title: 'C Cards',
        theme: ThemeData(colorScheme: .fromSeed(seedColor: Colors.deepPurple)),
        home: const ScreenRouter(),
      ),
    );
  }
}

class ScreenRouter extends StatefulWidget {
  const ScreenRouter({super.key});

  @override
  State<ScreenRouter> createState() => _ScreenRouterState();
}

class _ScreenRouterState extends State<ScreenRouter> {
  @override
  void initState() {
    Provider.of<AuthProvider>(context, listen: false).initAuthProvider();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Consumer<AuthProvider>(
      builder: (context, authConsumer, _) {
        switch (authConsumer.status) {
          case AuthStatus.authenticated:
            return const TabsScreen();
          case AuthStatus.unauthenticated:
            return const IntroScreen();
          case AuthStatus.authenticating:
            return const LoadingScreen();
          default:
            return const Wrong();
        }
      },
    );
  }
}
