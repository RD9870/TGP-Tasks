import 'package:flutter/foundation.dart';
import 'package:shared_preferences/shared_preferences.dart';

class DarkModeProvider with ChangeNotifier {
  bool isDark = false;

  Future<void> storeTolocalStorage() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    prefs.setBool("is_dark", isDark);
  }

  Future<void> getFromlocalStorage() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    isDark = prefs.getBool("is_dark") ?? false;
    notifyListeners();
  }

  Future<void> switchMode() async {
    isDark = !isDark;
    storeTolocalStorage();
    getFromlocalStorage();
    notifyListeners();
  }
}
