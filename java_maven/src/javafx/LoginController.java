package javafx;

import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.control.PasswordField;
import javafx.scene.control.TextField;
import javafx.scene.paint.Color;


public class LoginController {
    @FXML
    private Label statusLabel;
    @FXML
    private PasswordField passwordField;
    @FXML
    private TextField emailField;
    @FXML
    private Button loginButton;

    private MainApp mainApp;

    public void setStatusLabel(String status) {
        statusLabel.setText(status);
    }

    public void Login(ActionEvent event) {
        statusLabel.setVisible(true);
        statusLabel.setText(emailField.getText());

        User loginUser = mainApp.dataBaseDAO.Login(emailField.getText(), passwordField.getText());
        if (loginUser != null) {
            this.mainApp.showUserListView(loginUser);
        } else {
            statusLabel.setVisible(true);
            statusLabel.setTextFill(Color.web("#f20000"));
            statusLabel.setText("Identifiants incorrects !");
        }
    }

    public void setMainApp(MainApp main) {
        this.mainApp = main;
    }
}
