//
// Created by nou on 31/03/2020.
// Updated by Antoine on 06/04/2020.
//

#ifndef DRIVENCOOK_SUBSCRIBE_GTKFUNCTIONS_H
#define DRIVENCOOK_SUBSCRIBE_GTKFUNCTIONS_H

#include <gtk-3.0/gtk/gtk.h>
#include <time.h>
#include <assert.h>

#include "qrFunctions.h"
#include "codecFunctions.h"
#include "curlFunction.h"

GtkBuilder *builder;
extern char *gladeFile;
extern char *configFilePath;


typedef struct {
    GtkWidget *window;
    GtkButton *subscribeButton;
    GtkEntry *nameEntry;
    GtkEntry *firstNameEntry;
    GtkEntry *emailEntry;
    GtkLabel *statusLabel;
    GtkDialog *serverConfDialog;
    GtkButton *closeBtn;
    GtkButton *editBtn;
    GtkButton *saveBtn;
    GtkEntry *serverAddrEntry;
    GtkEntry *serverUsrEntry;
    GtkEntry *serverPwdEntry;
    GtkLabel *serverConfStatus;
    GtkDialog *passRequestDialog;
    GtkButton *okBtn;
    GtkButton *cancelBtn;
    GtkEntry *userLoginEntry;
    GtkEntry *userPwdEntry;
    GtkLabel *passRequestErr;

} AppWidgets;

AppWidgets *widgets;
CurlInfos userArgs;

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

G_MODULE_EXPORT void on_subscribeButton_clicked();

G_MODULE_EXPORT void on_configureButton_clicked();

G_MODULE_EXPORT void on_okButton_clicked();

G_MODULE_EXPORT void on_cancel_loginButton_clicked();

G_MODULE_EXPORT void on_saveButton_clicked();

G_MODULE_EXPORT void on_editButton_clicked();

G_MODULE_EXPORT void on_closeButton_clicked();

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


void startGTK(int *argc, char ***argv);

void connectWidgets();

void connectSignals();

void onDestroy();

void status(char *statusMessage);

void successStatus(char *statusMessage, GtkLabel *successLabel);

void errorStatus(char *statusMessage, GtkLabel *errorLabel);

int processConfigFile(GtkLabel *logLabel);

int processKeyFile(GtkLabel *logLabel);

int sendFile(char *filename);

char *checkInputs(const char *name, const char *firstName, const char *email);


void checkCredentials();

void loadServerConfig();

#endif //DRIVENCOOK_SUBSCRIBE_GTKFUNCTIONS_H
