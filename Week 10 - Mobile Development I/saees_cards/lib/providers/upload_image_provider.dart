import 'dart:io';

import 'package:flutter/widgets.dart';
import 'package:saees_cards/providers/base_provider.dart';
import 'package:image_picker/image_picker.dart';

class UploadImageProvider extends BaseProvider {
  File? selectedImgae;
  bool uploadCompleted = false;

  Future<void> fromGallery() async {
    uploadCompleted = false;
    setBusy(true);
    final returnedImage = await ImagePicker().pickImage(
      source: ImageSource.gallery,
    );
    if (returnedImage == null) {
      setBusy(false);
      return;
    }
    selectedImgae = File(returnedImage.path);
    debugPrint("Selected Image Path: ${selectedImgae!.path}");
    uploadCompleted = await api.uploadImage(selectedImgae!);
    debugPrint("uploadCompleted: $uploadCompleted");
    setBusy(false);
    notifyListeners();
  }

  Future<void> takePhoto() async {
    uploadCompleted = false;
    setBusy(true);
    final returnedImage = await ImagePicker().pickImage(
      source: ImageSource.camera,
    );
    if (returnedImage == null) {
      setBusy(false);
      return;
    }
    selectedImgae = File(returnedImage.path);
    debugPrint("Selected Image Path: ${selectedImgae!.path}");
    uploadCompleted = await api.uploadImage(selectedImgae!);
    debugPrint("uploadCompleted: $uploadCompleted");
    setBusy(false);
    notifyListeners();
  }
}
