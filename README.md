# FORMA APPLICATION WEB
Application pour les utilisateurs de la maison des ligues permettant leur(s) inscription(s) aux différentes formation et permet l'administration des formations à des utilisateurs possédant les pouvoirs d'admnistrateur.

>Pour plus d'informations sur les classes utilisés vous pouvez retrouver la [documentation](http://www.francois-garcia.ws/formaweb_doc/).

## Interface de connexion

Interface de connexion simple permettant la saisie de l'identifiant (e-amil) et mot de passe de l'utilisateur.
Le mot de passe utilise le protocole de cryptage **SHA1**.

![alt tag](https://i.gyazo.com/9a1a95c353b1f812ae2138d7180e8af9.png)

## Menu

Cette application dispose d'un menu après connexion, permettant à l'utilisateur de choisir l'action attendue.
L'utilisateur a le choix entre consulter les *stages de formations à venir* ou bien *consulter toutes les formations* disponibles.

## Formations à venir

L'utilisateur connecté peut consulter les stages de formations à venir par défaut d'une date allant du jour J au jour J+7.

![alt tag](https://i.gyazo.com/2655c347ef2f0c10ae110add482ba72d.png)

Afin de permettre la recherche de stages de formations par date, l'utilisateur dispose d'une fonction de **recherche avancée**.
Celle-ci fonctionne au travers de différent élément clé tel qu'une fourchette de date ou autre, recupéré afin de composer une requete SQL permettant son affichage filtré à l'aide de la fonction suivante :

``` c#
dbConnect.listViewStagesFormations(query, listViewStagesFormations);
```

Affichage du code de la fonction permettant le remplissage d'une ListView en fonction d'une requête SQL :
``` c#
public void listViewStagesFormations(string query, ListView p_listView)
        {
            // allow reload without superposition
            p_listView.Items.Clear();
            //Open connection
            if (this.OpenConnection() == true)
            {
                //Create Command
                MySqlCommand cmd = new MySqlCommand(query, connection);
                //Create a data reader and Execute the command
                MySqlDataReader dataReader = cmd.ExecuteReader();

                //Read the data and store them in the list
                while (dataReader.Read())
                {
                    ListViewItem item = new ListViewItem(dataReader["formations_intitule"].ToString());
                    item.SubItems.Add(dataReader["associations_nom"].ToString());
                    item.SubItems.Add(dataReader["salles_nom"].ToString());
                    item.SubItems.Add(dataReader["stages_formations_prix"].ToString());
                    item.SubItems.Add(dataReader["stages_formations_placeRestantes"].ToString());
                    item.SubItems.Add(dataReader["stages_formations_date"].ToString());

                    p_listView.Items.Add(item);
                }

                //close Data Reader
                dataReader.Close();

                //close Connection
                this.CloseConnection();

            }
            else
            {
                MessageBox.Show("Une erreur est survenue");
            }
        }
```

Ainsi il est plus facile de gérer l'espace de recherche avancée à partir de certains paramètres

![alt tag](https://i.gyazo.com/ae008bd2009de43e2a26f25590c07828.png)

Ainsi pour une nouvelle fourchette de date, il suffit à l'utilisateur de choisir une date à partir du **DateTimePicker** et de cliquer sur le bouton *Rechercher par date*.

Cela aura pour effet d'executer le code suivant :

``` c#
DBConnect dbConnect = new DBConnect();

// récupération des dates
string dateDebutUS = dateTimePickerDebut.Value.Date.ToString("yyyy/MM/dd");
string dateFinUS = dateTimePickerFin.Value.Date.ToString("yyyy/MM/dd");

// écriture de la requête
string query = "SELECT * FROM view_stages_formations WHERE stages_formations_date >= '" + dateDebutUS + "' AND stages_formations_date <= '" + dateFinUS + "'";

// remplissage de la ListView
dbConnect.listViewStagesFormations(query, listViewStagesFormations);
```
