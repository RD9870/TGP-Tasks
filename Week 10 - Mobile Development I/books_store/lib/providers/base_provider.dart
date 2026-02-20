import 'package:books_store/services/api.dart';
import 'package:flutter/cupertino.dart';

class BaseProvider with ChangeNotifier {
  // loading variable and api instance
  bool busy = false;
  Api api = Api();

  // change value of loading variable
  void setBusy(bool status) {
    busy = status;
    notifyListeners();
  }

  // failing flag variable
  bool failed = false;

  // change value of failing flag variable
  void setFailed(bool status) {
    failed = status;
    notifyListeners();
  }

  // error mesage variable
  String? errorMessage;

  // change value of error message variable
  void setErrorMessage(String? msg) {
    errorMessage = msg;
    notifyListeners();
  }
}
