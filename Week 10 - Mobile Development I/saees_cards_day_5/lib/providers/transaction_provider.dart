import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:saees_cards/models/transaction_model.dart';
import 'package:saees_cards/providers/base_provider.dart';

class TransactionsProvider extends BaseProvider {
  List<TransactionModel> transactions = [];
  final ScrollController controller = ScrollController();
  String? nextPageUrl;

  void getTransactions() async {
    setLisnter();
    setBusy(true);

    final response = await api.get("/vendor/transactions");

    if (response.statusCode == 200) {
      transactions = List<TransactionModel>.from(
        json
            .decode(response.body)['data']
            .map((e) => TransactionModel.fromJson(e as Map<String, dynamic>))
            .toList(),
      );
      nextPageUrl = json.decode(response.body)['links']['next'];
      setBusy(false);
    } else {
      transactions = [];
      setBusy(false);
    }
  }

  void setLisnter() {
    if (busy) return;
    controller.addListener(() {
      // debugPrint(
      //   "Scrolling... Current: ${controller.offset}, Max: ${controller.position.maxScrollExtent}",
      // );
      if (controller.offset == controller.position.maxScrollExtent) {
        getMoreTransactions();
        setBusy(false);
        notifyListeners();
      }
    });
  }

  void getMoreTransactions() async {
    setBusy(true);
    if (nextPageUrl == null) {
      transactions.addAll([
        TransactionModel(
          id: 111,
          user: User(id: 111, name: "test user"),
          type: "type",
          amount: "111",
          balanceBefore: "222",
          balanceAfter: "111",
          reference: "reference",
          description: "description",
        ),

        TransactionModel(
          id: 222,
          user: User(id: 222, name: "test user 2"),
          type: "type",
          amount: "222",
          balanceBefore: "333",
          balanceAfter: "111",
          reference: "reference 2",
          description: "description 2",
        ),

        TransactionModel(
          id: 333,
          user: User(id: 333, name: "test user"),
          type: "type",
          amount: "333",
          balanceBefore: "444",
          balanceAfter: "111",
          reference: "reference 3",
          description: "description 3",
        ),
      ]);
      setBusy(false);
      return;
    }

    final response = await api.get(nextPageUrl!);

    if (response.statusCode == 200) {
      List<TransactionModel> newTransactions = List<TransactionModel>.from(
        json
            .decode(response.body)['data']
            .map((e) => TransactionModel.fromJson(e as Map<String, dynamic>))
            .toList(),
      );
      nextPageUrl = json.decode(response.body)['links']['next'];
      transactions.addAll(newTransactions);
    }
    setBusy(false);
  }
}
