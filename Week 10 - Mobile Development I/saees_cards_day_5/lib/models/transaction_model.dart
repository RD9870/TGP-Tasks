// To parse this JSON data, do
//
//     final transactionModel = transactionModelFromJson(jsonString);

import 'dart:convert';

TransactionModel transactionModelFromJson(String str) =>
    TransactionModel.fromJson(json.decode(str));

String transactionModelToJson(TransactionModel data) =>
    json.encode(data.toJson());

class TransactionModel {
  int id;
  User user;
  String type;
  String amount;
  String balanceBefore;
  String balanceAfter;
  String reference;
  dynamic description;

  TransactionModel({
    required this.id,
    required this.user,
    required this.type,
    required this.amount,
    required this.balanceBefore,
    required this.balanceAfter,
    required this.reference,
    required this.description,
  });

  factory TransactionModel.fromJson(Map<String, dynamic> json) =>
      TransactionModel(
        id: json["id"],
        user: User.fromJson(json["user"]),
        type: json["type"],
        amount: json["amount"],
        balanceBefore: json["balance_before"],
        balanceAfter: json["balance_after"],
        reference: json["reference"],
        description: json["description"],
      );

  Map<String, dynamic> toJson() => {
    "id": id,
    "user": user.toJson(),
    "type": type,
    "amount": amount,
    "balance_before": balanceBefore,
    "balance_after": balanceAfter,
    "reference": reference,
    "description": description,
  };
}

class User {
  int id;
  String name;

  User({required this.id, required this.name});

  factory User.fromJson(Map<String, dynamic> json) =>
      User(id: json["id"], name: json["name"]);

  Map<String, dynamic> toJson() => {"id": id, "name": name};
}
