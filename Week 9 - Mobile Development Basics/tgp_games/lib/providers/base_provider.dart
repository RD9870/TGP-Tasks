import 'package:flutter/material.dart';
import 'package:tgp_games/services/api.dart';

// base provider: provider that has the basic function the other providers need
class BaseProvider with ChangeNotifier {
  // loading indicator and api instance
  bool busy = false;
  API api = API();
  // failed variable
  bool failed = false;

  // change the value of the loading indicator
  void setBusy(bool status) {
    busy = status;
    notifyListeners();
  }

  // change the value of the failed variable
  void setFailed(bool status) {
    failed = status;
    notifyListeners();
  }
}
