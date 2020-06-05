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
        System.out.println("Email : " + emailField.getText());
        System.out.println("Password : " + passwordField.getText());
        statusLabel.setVisible(true);
        statusLabel.setText(emailField.getText());

        User loginUser = mainApp.dataBaseDAO.Login(emailField.getText(), passwordField.getText());
        if (loginUser != null) {
            statusLabel.setTextFill(Color.web("#0cf200"));
            statusLabel.setText("Login valid !");
            this.mainApp.showUserListView(loginUser);
        } else {
            statusLabel.setTextFill(Color.web("#f20000"));
            statusLabel.setText("Login invalid !");
            this.mainApp.showUserListView(loginUser);

        }
    }

    public void setMainApp(MainApp main) {
        this.mainApp = main;
    }
}
