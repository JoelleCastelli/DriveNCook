//
// Created by nou on 31/03/2020.
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

} AppWidgets;

AppWidgets *widgets;
CurlInfos userArgs;

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

G_MODULE_EXPORT void on_subscribeButton_clicked();

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


void startGTK(int *argc, char ***argv);

void connectWidgets();

void connectSignals();

void onDestroy();

void status(char *statusMessage);

void successStatus(char *statusMessage);

void errorStatus(char *statusMessage);

void processConfigFile();

void processKeyFile();

int sendFile(char *filename);

char *checkInputs(const char *name, const char *firstName, const char *email);

#endif //DRIVENCOOK_SUBSCRIBE_GTKFUNCTIONS_H
