import 'package:flutter/foundation.dart';
import 'package:shared_preferences/shared_preferences.dart';

class DarkModeProvider with ChangeNotifier {
  // variable to control the mode
  bool isDark = false;

  // ADD the dark mode variabke to the local storage
  Future<void> storeTolocalStorage() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    prefs.setBool("is_dark", isDark);
  }

  // get the isDark variable saved in the Local storage
  Future<void> getFromlocalStorage() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    isDark = prefs.getBool("is_dark") ?? false;
    notifyListeners();
  }

  // change the mode from light to dark and back
  Future<void> switchMode() async {
    isDark = !isDark;
    storeTolocalStorage();
    getFromlocalStorage();
    notifyListeners();
  }
}
