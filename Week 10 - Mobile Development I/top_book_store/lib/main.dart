import 'package:top_book_store/providers/auth_provider.dart';
import 'package:top_book_store/screens/auth_screens/author_register_screen.dart';
// import 'package:top_book_store/screens/auth_screens/splash_screen.dart';
import 'package:top_book_store/screens/handling_screen/loading_screen.dart';
import 'package:top_book_store/screens/main_screens/home_screen.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:toastification/toastification.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MultiProvider(
      providers: [ChangeNotifierProvider(create: (_) => AuthProvider())],
      child: ToastificationWrapper(
        child: MaterialApp(
          debugShowCheckedModeBanner: false,
          title: 'Top Book Store',
          theme: ThemeData(
            colorScheme: .fromSeed(seedColor: Colors.deepPurple),
          ),
          home: RegisterScreen(), //SplashScreen(),
        ),
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
        return authConsumer.status == AuthStatus.authenticated
            ? HomeScreen()
            : authConsumer.status == AuthStatus.unauthenticated
            ? RegisterScreen()
            : authConsumer.status == AuthStatus.authenticating
            ? LoadingScreen()
            : LoadingScreen();
      },
    );
  }
}
