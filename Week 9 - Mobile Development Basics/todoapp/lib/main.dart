import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:provider/provider.dart';
import 'package:todoapp/providers/dark_mode_provider.dart';
import 'package:todoapp/providers/tasks_provider.dart';
import 'package:todoapp/screen/home_screen.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return
    // allows the injection of multiple state providers (data models, services) into the Flutter widget tree at once, making them available to the entire application
    MultiProvider(
      providers: [
        ChangeNotifierProvider<TasksProvider>(create: (_) => TasksProvider()),
        ChangeNotifierProvider<DarkModeProvider>(
          create: (_) => DarkModeProvider()..getFromlocalStorage(),
        ),
      ],
      //
      child: Consumer<DarkModeProvider>(
        builder: (context, darkModeConsumer, _) {
          return MaterialApp(
            debugShowCheckedModeBanner: false,
            title: 'TODO',
            // theme sittings
            theme: ThemeData(
              textTheme: GoogleFonts.cairoTextTheme(),
              scaffoldBackgroundColor: darkModeConsumer.isDark
                  ? Colors.black
                  : Colors.white,
              colorScheme: .fromSeed(seedColor: Colors.blue),
              tabBarTheme: TabBarThemeData(
                labelStyle: GoogleFonts.cairo(
                  color: darkModeConsumer.isDark ? Colors.white : Colors.blue,
                ),
                // color of the bar ujnder the selected tab in a tabbar
                indicatorColor: darkModeConsumer.isDark
                    ? Colors.white
                    : Colors.blue,
              ),
              // dialog theme
              dialogTheme: DialogThemeData(
                backgroundColor: darkModeConsumer.isDark
                    ? Colors.white60
                    : Colors.white,
                // title theme
                titleTextStyle: TextStyle(
                  color: darkModeConsumer.isDark ? Colors.white : Colors.black,
                ),
              ),
              // appbar
              appBarTheme: AppBarThemeData(
                backgroundColor: darkModeConsumer.isDark
                    ? Colors.black
                    : Colors.blue,
              ),
              // text fields theme
              inputDecorationTheme: InputDecorationThemeData(
                fillColor: darkModeConsumer.isDark
                    ? Colors.white54
                    : Colors.white,
                filled: true,
                border: OutlineInputBorder(
                  borderRadius: BorderRadius.circular(12),
                ),
                focusedBorder: OutlineInputBorder(
                  borderRadius: BorderRadius.circular(12),
                  borderSide: BorderSide(color: Colors.blue),
                ),
                errorBorder: OutlineInputBorder(
                  borderRadius: BorderRadius.circular(12),
                  borderSide: BorderSide(color: Colors.red),
                ),
              ),
              // theme for eleveated btns
              elevatedButtonTheme: ElevatedButtonThemeData(
                style: ButtonStyle(
                  backgroundColor: WidgetStatePropertyAll(Colors.blue),
                  foregroundColor: WidgetStatePropertyAll(Colors.white),
                  shape: WidgetStatePropertyAll(
                    RoundedRectangleBorder(
                      borderRadius: BorderRadiusGeometry.circular(12),
                    ),
                  ),
                ),
              ),
            ),
            home: HomeScreen(),
          );
        },
      ),
    );
  }
}
