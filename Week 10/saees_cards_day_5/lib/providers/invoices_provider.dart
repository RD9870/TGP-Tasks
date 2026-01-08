import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:saees_cards/models/invoice_model.dart';
import 'package:saees_cards/providers/base_provider.dart';

class InvoicesProvider extends BaseProvider {
  final ScrollController controller = ScrollController();
  String? nextPageUrl;

  void setLisnter() {
    if (busy) return;
    controller.addListener(() {
      // debugPrint(
      //   "Scrolling... Current: ${controller.offset}, Max: ${controller.position.maxScrollExtent}",
      // );
      if (controller.offset == controller.position.maxScrollExtent) {
        getMoreInvoices();
        setBusy(false);
        notifyListeners();
      }
    });
  }

  void getMoreInvoices() async {
    setBusy(true);
    if (nextPageUrl == null) {
      invoices.addAll([
        InvoiceModel(
          id: 111,
          invoiceNumber: "111",
          amount: "111",
          vendorId: 111,
          walletId: 111,
          familyId: 111,
          image: "image",
          status: "status",
          approvedBy: "approvedBy",
          approvedAt: "approvedAt",
          createdAt: DateTime.now(),
          updatedAt: DateTime.now(),
          wallet: FamilyWalletModel(
            id: 111,
            uuid: "111",
            familyId: 111,
            balance: "11111",
            notes: "notes",
            isActive: true,
            expiryDate: DateTime.now(),
            createdBy: 11,
            deactivatedBy: null,
            deactivatedAt: null,
            createdAt: DateTime.now(),
            updatedAt: DateTime.now(),
            deletedAt: null,
            serialNumber: "111",
            institutionId: 11,
          ),
          family: FamilyModel(
            id: 58,
            institutionId: 1,
            name: "اسماعيل عبد الله محمد احمد",
            code: "56165",
            headOfFamily: "اسماعيل عبد الله محمد احمد",
            phone: "0928596774",
            email: null,
            address: null,
            membersCount: 7,
            isActive: true,
            nationalityId: 2,
            createdAt: DateTime.now(),
            updatedAt: DateTime.now(),
            deletedAt: null,
          ),
        ),

        InvoiceModel(
          id: 112,
          invoiceNumber: "112",
          amount: "222",
          vendorId: 105,
          walletId: 112,
          familyId: 59,
          image: "https://example.com/inv_112.png",
          status: "pending",
          approvedBy: "admin_user",
          approvedAt: "2024-05-10 10:00",
          createdAt: DateTime.now().subtract(const Duration(days: 1)),
          updatedAt: DateTime.now().subtract(const Duration(days: 1)),
          wallet: FamilyWalletModel(
            id: 112,
            uuid: "112-uuid-abc",
            familyId: 59,
            balance: "8500",
            notes: "Monthly allocation",
            isActive: true,
            expiryDate: DateTime.now().add(const Duration(days: 300)),
            createdBy: 11,
            deactivatedBy: null,
            deactivatedAt: null,
            createdAt: DateTime.now(),
            updatedAt: DateTime.now(),
            deletedAt: null,
            serialNumber: "SN-998877",
            institutionId: 11,
          ),
          family: FamilyModel(
            id: 59,
            institutionId: 1,
            name: "علي محمد حسن علي",
            code: "56166",
            headOfFamily: "علي محمد حسن علي",
            phone: "0915544332",
            email: "ali.family@example.com",
            address: "طرابلس - حي الأندلس",
            membersCount: 5,
            isActive: true,
            nationalityId: 2,
            createdAt: DateTime.now(),
            updatedAt: DateTime.now(),
            deletedAt: null,
          ),
        ),

        InvoiceModel(
          id: 113,
          invoiceNumber: "113",
          amount: "333S",
          vendorId: 108,
          walletId: 113,
          familyId: 60,
          image: "https://example.com/inv_113.png",
          status: "approved",
          approvedBy: "manager_01",
          approvedAt: "2024-05-11 14:30",
          createdAt: DateTime.now(),
          updatedAt: DateTime.now(),
          wallet: FamilyWalletModel(
            id: 113,
            uuid: "113-uuid-xyz",
            familyId: 60,
            balance: "12400",
            notes: "Emergency fund",
            isActive: true,
            expiryDate: DateTime.now().add(const Duration(days: 180)),
            createdBy: 12,
            deactivatedBy: null,
            deactivatedAt: null,
            createdAt: DateTime.now(),
            updatedAt: DateTime.now(),
            deletedAt: null,
            serialNumber: "SN-112233",
            institutionId: 11,
          ),
          family: FamilyModel(
            id: 60,
            institutionId: 1,
            name: "فاطمة إبراهيم الصديق",
            code: "56167",
            headOfFamily: "فاطمة إبراهيم الصديق",
            phone: "0924455667",
            email: null,
            address: "بنغازي - الصابري",
            membersCount: 4,
            isActive: true,
            nationalityId: 2,
            createdAt: DateTime.now(),
            updatedAt: DateTime.now(),
            deletedAt: null,
          ),
        ),
      ]);
      setBusy(false);
      return;
    }

    final response = await api.get(nextPageUrl!);

    if (response.statusCode == 200) {
      List<InvoiceModel> newInvoices = List<InvoiceModel>.from(
        json
            .decode(response.body)['data']
            .map((e) => InvoiceModel.fromJson(e as Map<String, dynamic>))
            .toList(),
      );
      nextPageUrl = json.decode(response.body)['links']['next'];
      invoices.addAll(newInvoices);
    }
    setBusy(false);
  }

  Future<List<dynamic>> validateCard(Map body) async {
    setBusy(true);
    final response = await api.post("/vendor/wallets/validate", body);

    if (response.statusCode == 200) {
      setBusy(false);

      return [true, json.decode(response.body)['data']['balance']];
    } else {
      setBusy(false);

      return [false, "This card is invalid"];
    }
  }

  List<InvoiceModel> invoices = [];

  void getInvoices() async {
    setBusy(true);

    final response = await api.get("/vendor/invoices");

    if (response.statusCode == 200) {
      invoices = List<InvoiceModel>.from(
        json
            .decode(response.body)['data']
            .map((e) => InvoiceModel.fromJson(e as Map<String, dynamic>))
            .toList(),
      );
      nextPageUrl = json.decode(response.body)['links']['next'];
      setBusy(false);
    } else {
      invoices = [];
      setBusy(false);
    }
  }

  Future<List> placeInvoice(Map body) async {
    setBusy(true);
    final response = await api.post("/vendor/invoices", body);
    if (response.statusCode == 201) {
      getInvoices();
      return [true, "Invoice Added Successfully"];
    } else {
      setBusy(false);

      return [false, json.decode(response.body)["message"]];
    }
  }
}
