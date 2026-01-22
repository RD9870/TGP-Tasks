import 'package:flutter/material.dart';
import 'package:tgp_games/services/api.dart';

class BaseProvider with ChangeNotifier {
  bool busy = false;
  API api = API();

  void setBusy(bool status) {
    busy = status;
    notifyListeners();
  }

  bool failed = false;

  void setFailed(bool status) {
    failed = status;
    notifyListeners();
  }
}
