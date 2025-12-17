# 📦 دليل استيراد Collections إلى Firebase

## 📋 المتطلبات

### 1. تثبيت Node.js و npm
تأكد من تثبيت Node.js على جهازك:
```bash
node --version
npm --version
```

### 2. تثبيت Firebase Admin SDK
```bash
npm install firebase-admin
```

### 3. إعداد ملف credentials.json

#### الطريقة 1: استخدام Service Account (موصى به)

1. اذهب إلى [Firebase Console](https://console.firebase.google.com/)
2. اختر المشروع `foodgo-e1252`
3. اذهب إلى **Project Settings** → **Service Accounts**
4. اضغط **Generate New Private Key**
5. سيتم تحميل ملف JSON
6. انسخ محتوى الملف إلى `credentials.json` في مجلد المشروع

#### الطريقة 2: استخدام Firebase CLI (بديل)

إذا كان لديك Firebase CLI مثبت ومسجل دخول:
```bash
firebase login
```

---

## 🚀 خطوات الاستيراد

### الخطوة 1: إنشاء ملف credentials.json

انسخ ملف `credentials.json.example` إلى `credentials.json` واملأ البيانات:

```bash
copy credentials.json.example credentials.json
```

أو أنشئ ملف جديد `credentials.json` واملأه بالبيانات من Firebase Console.

### الخطوة 2: تشغيل Script الاستيراد

```bash
node import-firestore.js
```

---

## 📝 مثال على ملف credentials.json

```json
{
  "type": "service_account",
  "project_id": "foodgo-e1252",
  "private_key_id": "your-private-key-id",
  "private_key": "-----BEGIN PRIVATE KEY-----\nYOUR_PRIVATE_KEY_HERE\n-----END PRIVATE KEY-----\n",
  "client_email": "firebase-adminsdk-xxxxx@foodgo-e1252.iam.gserviceaccount.com",
  "client_id": "your-client-id",
  "auth_uri": "https://accounts.google.com/o/oauth2/auth",
  "token_uri": "https://oauth2.googleapis.com/token",
  "auth_provider_x509_cert_url": "https://www.googleapis.com/oauth2/v1/certs",
  "client_x509_cert_url": "https://www.googleapis.com/robot/v1/metadata/x509/..."
}
```

---

## ⚠️ تحذيرات مهمة

### 1. **Backup البيانات الموجودة**
قبل الاستيراد، تأكد من عمل backup للبيانات الموجودة في Firestore:
- اذهب إلى Firebase Console → Firestore → Data
- استخدم Export Data لتصدير البيانات الحالية

### 2. **Merge vs Overwrite**
الـ script يستخدم `merge: true`، مما يعني:
- ✅ البيانات الجديدة ستضاف
- ✅ البيانات الموجودة ستُحدث إذا كان نفس Document ID
- ⚠️ البيانات الموجودة لن تُحذف إلا إذا كانت في الملف

### 3. **حجم البيانات**
ملف `collections.json` كبير جداً (81,275 سطر). قد يستغرق الاستيراد وقتاً طويلاً.

---

## 🔧 خيارات متقدمة

### استيراد Collection معين فقط

يمكنك تعديل `import-firestore.js` لاستيراد collection معين:

```javascript
// في الدالة main()
const collectionsToImport = ['vendors', 'users']; // أضف Collections المطلوبة

for (const collectionName of collectionsToImport) {
  if (collections[collectionName]) {
    await importCollection(collectionName, collections[collectionName]);
  }
}
```

### تغيير Batch Size

إذا واجهت مشاكل في الذاكرة، قلل حجم الـ batch:

```javascript
await importCollection(collectionName, collections[collectionName], 100); // بدلاً من 500
```

---

## 📊 Collections المتاحة في الملف

من ملف `collections.json`، الـ Collections التالية متاحة:

- `advertisements`
- `booked_table`
- `cashback`
- `chat`
- `chat_admin`
- `chat_driver`
- `chat_restaurant`
- `cms_pages`
- `coupons`
- `currencies`
- `driver_payouts`
- `favorite_restaurant`
- `foods_review`
- `gift_purchases`
- `menu_items`
- `order_transactions`
- `payouts`
- `pos_orders`
- `restaurant_orders`
- `subscription_history`
- `subscription_plans`
- `thread`
- `users`
- `vendor_categories`
- `vendor_orders`
- `vendor_products`
- `vendors`
- `wallet`
- `zone`
- وغيرها...

---

## ✅ التحقق من نجاح الاستيراد

بعد الانتهاء من الاستيراد:

1. **Firebase Console** → **Firestore Database** → **Data**
2. تحقق من وجود الـ Collections المستوردة
3. تحقق من عدد Documents في كل Collection
4. افتح بعض Documents للتحقق من البيانات

---

## 🐛 حل المشاكل

### خطأ: "credentials.json غير موجود"
- ✅ تأكد من وجود ملف `credentials.json` في المجلد الرئيسي
- ✅ تأكد من أن الملف يحتوي على البيانات الصحيحة

### خطأ: "Permission denied"
- ✅ تأكد من أن Service Account لديه صلاحيات Firestore
- ✅ اذهب إلى Firebase Console → IAM & Admin → Service Accounts
- ✅ تأكد من أن Service Account لديه دور "Firebase Admin SDK Administrator Service Agent"

### خطأ: "Memory limit exceeded"
- ✅ قلل حجم الـ batch في `import-firestore.js`
- ✅ استورد Collections بشكل منفصل

### خطأ: "Invalid timestamp"
- ✅ الـ script يتعامل مع Timestamps تلقائياً
- ✅ إذا استمرت المشكلة، تحقق من تنسيق Timestamps في الملف

---

## 📞 ملاحظات إضافية

1. **الوقت المتوقع**: حسب حجم البيانات، قد يستغرق الاستيراد من 10 دقائق إلى ساعة
2. **الاتصال بالإنترنت**: تأكد من اتصال مستقر بالإنترنت
3. **الـ Logs**: الـ script يعرض تقدم الاستيراد لكل Collection

---

## 🎯 الخطوات السريعة

```bash
# 1. تثبيت Firebase Admin SDK
npm install firebase-admin

# 2. إنشاء credentials.json من Firebase Console

# 3. تشغيل Script
node import-firestore.js

# 4. انتظار الانتهاء والتحقق من النتائج
```

---

**تم!** 🎉




## 📋 المتطلبات

### 1. تثبيت Node.js و npm
تأكد من تثبيت Node.js على جهازك:
```bash
node --version
npm --version
```

### 2. تثبيت Firebase Admin SDK
```bash
npm install firebase-admin
```

### 3. إعداد ملف credentials.json

#### الطريقة 1: استخدام Service Account (موصى به)

1. اذهب إلى [Firebase Console](https://console.firebase.google.com/)
2. اختر المشروع `foodgo-e1252`
3. اذهب إلى **Project Settings** → **Service Accounts**
4. اضغط **Generate New Private Key**
5. سيتم تحميل ملف JSON
6. انسخ محتوى الملف إلى `credentials.json` في مجلد المشروع

#### الطريقة 2: استخدام Firebase CLI (بديل)

إذا كان لديك Firebase CLI مثبت ومسجل دخول:
```bash
firebase login
```

---

## 🚀 خطوات الاستيراد

### الخطوة 1: إنشاء ملف credentials.json

انسخ ملف `credentials.json.example` إلى `credentials.json` واملأ البيانات:

```bash
copy credentials.json.example credentials.json
```

أو أنشئ ملف جديد `credentials.json` واملأه بالبيانات من Firebase Console.

### الخطوة 2: تشغيل Script الاستيراد

```bash
node import-firestore.js
```

---

## 📝 مثال على ملف credentials.json

```json
{
  "type": "service_account",
  "project_id": "foodgo-e1252",
  "private_key_id": "your-private-key-id",
  "private_key": "-----BEGIN PRIVATE KEY-----\nYOUR_PRIVATE_KEY_HERE\n-----END PRIVATE KEY-----\n",
  "client_email": "firebase-adminsdk-xxxxx@foodgo-e1252.iam.gserviceaccount.com",
  "client_id": "your-client-id",
  "auth_uri": "https://accounts.google.com/o/oauth2/auth",
  "token_uri": "https://oauth2.googleapis.com/token",
  "auth_provider_x509_cert_url": "https://www.googleapis.com/oauth2/v1/certs",
  "client_x509_cert_url": "https://www.googleapis.com/robot/v1/metadata/x509/..."
}
```

---

## ⚠️ تحذيرات مهمة

### 1. **Backup البيانات الموجودة**
قبل الاستيراد، تأكد من عمل backup للبيانات الموجودة في Firestore:
- اذهب إلى Firebase Console → Firestore → Data
- استخدم Export Data لتصدير البيانات الحالية

### 2. **Merge vs Overwrite**
الـ script يستخدم `merge: true`، مما يعني:
- ✅ البيانات الجديدة ستضاف
- ✅ البيانات الموجودة ستُحدث إذا كان نفس Document ID
- ⚠️ البيانات الموجودة لن تُحذف إلا إذا كانت في الملف

### 3. **حجم البيانات**
ملف `collections.json` كبير جداً (81,275 سطر). قد يستغرق الاستيراد وقتاً طويلاً.

---

## 🔧 خيارات متقدمة

### استيراد Collection معين فقط

يمكنك تعديل `import-firestore.js` لاستيراد collection معين:

```javascript
// في الدالة main()
const collectionsToImport = ['vendors', 'users']; // أضف Collections المطلوبة

for (const collectionName of collectionsToImport) {
  if (collections[collectionName]) {
    await importCollection(collectionName, collections[collectionName]);
  }
}
```

### تغيير Batch Size

إذا واجهت مشاكل في الذاكرة، قلل حجم الـ batch:

```javascript
await importCollection(collectionName, collections[collectionName], 100); // بدلاً من 500
```

---

## 📊 Collections المتاحة في الملف

من ملف `collections.json`، الـ Collections التالية متاحة:

- `advertisements`
- `booked_table`
- `cashback`
- `chat`
- `chat_admin`
- `chat_driver`
- `chat_restaurant`
- `cms_pages`
- `coupons`
- `currencies`
- `driver_payouts`
- `favorite_restaurant`
- `foods_review`
- `gift_purchases`
- `menu_items`
- `order_transactions`
- `payouts`
- `pos_orders`
- `restaurant_orders`
- `subscription_history`
- `subscription_plans`
- `thread`
- `users`
- `vendor_categories`
- `vendor_orders`
- `vendor_products`
- `vendors`
- `wallet`
- `zone`
- وغيرها...

---

## ✅ التحقق من نجاح الاستيراد

بعد الانتهاء من الاستيراد:

1. **Firebase Console** → **Firestore Database** → **Data**
2. تحقق من وجود الـ Collections المستوردة
3. تحقق من عدد Documents في كل Collection
4. افتح بعض Documents للتحقق من البيانات

---

## 🐛 حل المشاكل

### خطأ: "credentials.json غير موجود"
- ✅ تأكد من وجود ملف `credentials.json` في المجلد الرئيسي
- ✅ تأكد من أن الملف يحتوي على البيانات الصحيحة

### خطأ: "Permission denied"
- ✅ تأكد من أن Service Account لديه صلاحيات Firestore
- ✅ اذهب إلى Firebase Console → IAM & Admin → Service Accounts
- ✅ تأكد من أن Service Account لديه دور "Firebase Admin SDK Administrator Service Agent"

### خطأ: "Memory limit exceeded"
- ✅ قلل حجم الـ batch في `import-firestore.js`
- ✅ استورد Collections بشكل منفصل

### خطأ: "Invalid timestamp"
- ✅ الـ script يتعامل مع Timestamps تلقائياً
- ✅ إذا استمرت المشكلة، تحقق من تنسيق Timestamps في الملف

---

## 📞 ملاحظات إضافية

1. **الوقت المتوقع**: حسب حجم البيانات، قد يستغرق الاستيراد من 10 دقائق إلى ساعة
2. **الاتصال بالإنترنت**: تأكد من اتصال مستقر بالإنترنت
3. **الـ Logs**: الـ script يعرض تقدم الاستيراد لكل Collection

---

## 🎯 الخطوات السريعة

```bash
# 1. تثبيت Firebase Admin SDK
npm install firebase-admin

# 2. إنشاء credentials.json من Firebase Console

# 3. تشغيل Script
node import-firestore.js

# 4. انتظار الانتهاء والتحقق من النتائج
```

---

**تم!** 🎉
























